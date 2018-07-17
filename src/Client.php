<?php

namespace Omniva;

use Omniva\Parcel;
use Omniva\Service;
use SoapVar;
use XMLWriter;
use stdClass;
use SoapClient;
use GuzzleHttp\Client as HttpClient;
use Omniva\PickupPoint;

class Client
{
    private $username;

    private $password;

    private $httpClient;

    private $soapClient;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * returned object structure:
     *
     * object(stdClass)#11 (4) {
     *  ["partner"]=> "string"
     *  ["provider"]=> "string, example: EEPOST"
     *  ["prompt"]=> "string: message from API"
     *  ["savedPacketInfo"]=> object(stdClass)#12 (1) {
     *      ["barcodeInfo"]=> object(stdClass)#13 (2) {
     *          ["clientItemId"]=> "string"
     *          ["barcode"]=> "string"
     *      }
     *  }
     * }
     */
    public function createShipment(Parcel $parcel): stdClass
    {
        $writer = new XMLWriter;
        $writer->openMemory();

        $writer->startElement('ns1:businessToClientMsgRequest');

        $writer->writeElement('partner', $this->username);

        $writer->startElement('interchange');
        $writer->writeAttribute('msg_type', 'elsinfov1');

        $writer->startElement('header');
        $writer->writeAttribute('file_id', date("YmdHms"));
        $writer->writeAttribute('sender_cd', $this->username);
        $writer->endElement();

        $writer->startElement('item_list');

        $writer->startElement('item');
        $receiver = $parcel->getReceiver();

        $hasPickupPoint = $receiver->getPickupPoint() instanceof PickupPoint;
        $pickupPoint = $receiver->getPickupPoint();

        if ($hasPickupPoint) {
            if ($pickupPoint->isPostOffice()) {
                $deliveryServiceCode = Service::POST_OFFICE();
            } else if ($pickupPoint->isTerminal()) {
                $deliveryServiceCode = Service::TERMINAL();
            } else {
                throw new \RuntimeException('Wrong PickupPoint provided');
            }
        } else {
            $deliveryServiceCode = in_array($receiver->getCountryCode(), ['LT', 'LV']) ? Service::COURIER_LT_LV() : Service::COURIER();
        }

        $writer->writeAttribute('service', $deliveryServiceCode->getValue());

        if ($parcel->hasServices()) {
            $writer->startElement('add_service');
            foreach ($parcel->getServices() as $service) {
                $writer->startElement('option');
                $writer->writeAttribute('code', $service->getValue());
                $writer->endElement();
            }
            $writer->endElement();
        }

        $writer->startElement('measures');
        $writer->writeAttribute('weight', $parcel->getWeight());
        $writer->endElement();

        if ($parcel->getCodAmount()) {
            $writer->startElement('monetary_values');

            $writer->startElement('values');
            $writer->writeAttribute('code', 'item_value');
            $writer->writeAttribute('amount', $parcel->getCodAmount());
            $writer->endElement();

            $writer->endElement();

            $writer->writeElement('account', $parcel->getBankAccount());
        }

        if ($parcel->hasComment()) {
            $writer->writeElement('comment', $parcel->getComment());
        }

        $writer->writeElement('partnerId', $parcel->getPartnerId());

        $writer->startElement('receiverAddressee');
        $writer->writeElement('person_name', $receiver->getName());
        $writer->writeElement('mobile', $receiver->getPhone());
        if ($receiver->hasEmail()) {
            $writer->writeElement('email', $receiver->getEmail());
        }

        $writer->startElement('address');

        if ($hasPickupPoint) {
            $writer->writeAttribute('offloadPostcode', $pickupPoint->getIdentifier());
        } else {
            $writer->writeAttribute('postcode', $receiver->getPostCode());
            $writer->writeAttribute('deliverypoint', $receiver->getCity());
            $writer->writeAttribute('street', $receiver->getStreet());
        }

        $writer->writeAttribute('country', $receiver->getCountryCode());
        $writer->endElement();

        $writer->endElement();

        $writer->startElement('returnAddressee');
        $returnAddress = $parcel->getReturnee();
        $writer->writeElement('person_name', $returnAddress->getName());
        $writer->writeElement('mobile', $returnAddress->getPhone());
        if ($returnAddress->hasEmail()) {
            $writer->writeElement('email', $returnAddress->getEmail());
        }

        $writer->startElement('address');
        $writer->writeAttribute('postcode', $returnAddress->getPostCode());
        $writer->writeAttribute('deliverypoint', $returnAddress->getCity());
        $writer->writeAttribute('street', $returnAddress->getStreet());
        $writer->writeAttribute('country', $returnAddress->getCountryCode());
        $writer->endElement();
        $writer->endElement();

        $writer->startElement('onloadAddressee');
        $sender = $parcel->getSender();
        $writer->writeElement('person_name', $sender->getName());
        $writer->writeElement('mobile', $sender->getPhone());
        if ($sender->hasEmail()) {
            $writer->writeElement('email', $sender->getEmail());
        }

        $writer->startElement('address');
        $writer->writeAttribute('postcode', $sender->getPostCode());
        $writer->writeAttribute('deliverypoint', $sender->getCity());
        $writer->writeAttribute('street', $sender->getStreet());
        $writer->writeAttribute('country', $sender->getCountryCode());
        $writer->endElement();
        $writer->endElement();

        $writer->endElement();

        $writer->endElement();

        $writer->endElement();
        $writer->endElement();

        return $this->getSoapClient()->businessToClientMsg(
            new SoapVar($writer->outputMemory(), XSD_ANYXML)
        );
    }

    /**
     * response structure
     *
     * object(stdClass)#8 (3) {
     *  ["partner"]=> "string"
     *  ["failedAddressCards"]=> object(stdClass)#9 (0) {}
     *  ["successAddressCards"]=> object(stdClass)#10 (1) {
     *      ["addressCardData"]=> object(stdClass)#11 (2) {
     *          ["barcode"]=> "string"
     *          ["fileData"]=>  "base64 encoded string"
     *      }
     *  }
     * }
     */
    public function getLabel(Parcel $parcel): stdClass
    {
        if (!$parcel->hasTrackingNumber()) {
            throw new \InvalidArgumentException('Parcel must have tracking number');
        }

        $writer = new XMLWriter();
        $writer->openMemory();

        $writer->startElement('ns1:addrcardMsgRequest');
        $writer->writeElement('partner', $this->username);
        $writer->writeElement('sendAddressCardTo', 'response');
        $writer->startElement('barcodes');
        $writer->writeElement('barcode', $parcel->getTrackingNumber());
        $writer->endElement();
        $writer->endElement();

        return $this->getSoapClient()->addrcardMsg(
            new SoapVar($writer->outputMemory(), XSD_ANYXML)
        );
    }

    public function getSoapCLient(): SoapClient
    {
        if (!$this->soapClient instanceof SoapClient) {
            $this->soapClient = new SoapClient(
                'https://edixml.post.ee/epmx/services/messagesService.wsdl',
                [
                    'login' => $this->username,
                    'password' => $this->password,
                    'trace' => true,
                    'exceptions' => true
                ]
            );
        }

        return $this->soapClient;
    }

    public function getHttpClient(): HttpClient
    {
        if (!$this->httpClient instanceof HttpClient) {
            $this->httpClient = new HttpClient();
        }

        return $this->httpClient;
    }

    /**
     * multidimension array with item structure:
     *
     * array(25) {
     *  [0]=> string(6) "﻿ZIP"
     *  [1]=> string(4) "NAME"
     *  [2]=> string(4) "TYPE"
     *  [3]=> string(7) "A0_NAME"
     *  [4]=> string(7) "A1_NAME"
     *  [5]=> string(7) "A2_NAME"
     *  [6]=> string(7) "A3_NAME"
     *  [7]=> string(7) "A4_NAME"
     *  [8]=> string(7) "A5_NAME"
     *  [9]=> string(7) "A6_NAME"
     *  [10]=> string(7) "A7_NAME"
     *  [11]=> string(7) "A8_NAME"
     *  [12]=> string(12) "X_COORDINATE"
     *  [13]=> string(12) "Y_COORDINATE"
     *  [14]=> string(13) "SERVICE_HOURS"
     *  [15]=> string(18) "TEMP_SERVICE_HOURS"
     *  [16]=> string(24) "TEMP_SERVICE_HOURS_UNTIL"
     *  [17]=> string(20) "TEMP_SERVICE_HOURS_2"
     *  [18]=> string(26) "TEMP_SERVICE_HOURS_2_UNTIL"
     *  [19]=> string(11) "comment_est"
     *  [20]=> string(11) "comment_eng"
     *  [21]=> string(11) "comment_rus"
     *  [22]=> string(11) "comment_lav"
     *  [23]=> string(11) "comment_lit"
     *  [24]=> string(8) "MODIFIED"
     * }
     */
    public function getPickupPoints(): array
    {
        $response = $this->getHttpClient()->request('GET', 'https://www.omniva.ee/locations.csv');

        $content = (string)$response->getBody();

        $pickupPoints = [];
        $file = fopen('php://temp','r+');
        fwrite($file, $content);
        rewind($file); //rewind to process CSV
        while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
            $pickupPoints[] = $row;
        }

        // remove first item because it has only titles
        unset($pickupPoints[0]);

        return $pickupPoints;
    }
}
