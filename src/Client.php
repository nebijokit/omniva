<?php

namespace Omniva;

use Omniva\Parcel;
use Omniva\Service;
use SoapVar;
use XMLWriter;
use stdClass;

class Client
{
    private $username;

    private $password;

    private $client;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->client = new \SoapClient(
            'https://edixml.post.ee/epmx/services/messagesService.wsdl',
            [
                'login' => $this->username,
                'password' => $this->password,
                'trace' => true,
                'exceptions' => true
            ]
        );
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
        if ($receiver->hasTerminal()) {
            $deliveryServiceCode = Service::TERMINAL();
        } else {
            $deliveryServiceCode = in_array($receiver->getCountryCode(), ['LT', 'LV']) ? Service::COURIER_LT_LV() : Service::COURIER();
        }

        $writer->writeAttribute('service', $deliveryServiceCode->getValue());

        if ($parcel->hasServices()) {
            $writer->startElement('add_service');
            foreach ($parcel->getServices() as $service) {
                $writer->writeElement('option', $service->getValue());
            }
            $writer->endElement();
        }

        $writer->startElement('measures');
        $writer->writeAttribute('weight', $parcel->getWeight());
        $writer->endElement();

        if ($parcel->getCodAmount()) {
            $writer->startElement('monetary_values');
            $writer->writeElement('item_value', $parcel->getCodAmount());
            $writer->endDocument();

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
        if ($receiver->hasTerminal()) {
            $writer->writeAttribute('offloadPostcode', $receiver->getTerminal());
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

        return $this->client->businessToClientMsg(
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

        return $this->client->addrcardMsg(
            new SoapVar($writer->outputMemory(), XSD_ANYXML)
        );
    }
}
