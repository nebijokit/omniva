<?php

namespace Omniva;
use Omniva\Service;
use ArrayIterator;

class Parcel
{
    private $username;

    /**
     * weight in grams
     */
    private $weight;

    private $services;

    /**
     * amount in euros
     */
    private $codAmount;

    /**
     * bank account number (IBAN)
     */
    private $bankAccount;

    private $comment;
    private $partnerId;

    public $receiver;
    public $return;
    public $sender;

    public function __construct()
    {
        $this->services = new ArrayIterator();
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * in grams
     */
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
        return $this;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setPartnerId(string $partnerId): self
    {
        $this->partnerId = $partnerId;
        return $this;
    }

    public function getPartnerId(): string
    {
        return $this->partnerId;
    }

    public function setCodAmount(float $amount): self
    {
        $this->codAmount = $amount;
        return $this;
    }

    public function getCodAmount(): float
    {
        return $this->codAmount;
    }

    public function setBankAccount(string $number): self
    {
        $this->bankAccount = $number;
        return $this;
    }

    public function getBankAccount(): string
    {
        return $this->bankAccount;
    }

    public function addService(Service $service): self
    {
        $this->services->append($service);
        return $this;
    }

    public function getServices(): ArrayIterator
    {
        return $this->services;
    }

    public function toXml(): string
    {
        $writer = new \XmlWriter();
        $writer->openMemory();

        $writer->writeElement('partner', $this->getUsername());

        $writer->startElement('interchange');
        $writer->writeAttribute('msg_type', 'elsinfov1');

        $writer->startElement('header');
        $writer->writeAttribute('file_id', date("YmdHms"));
        $writer->writeAttribute('sender_cd', $this->getUsername());
        $writer->endElement();

        $writer->startElement('item_list');
        $writer->startElement('item');
        $writer->writeAttribute('service', 'QP');

        if ($this->hasServices()) {
            $writer->startElement('add_service');
            foreach ($this->getServices() as $service) {
                $writer->writeElement('option', $service);
            }
            $writer->endElement();
        }

        $writer->startElement('measures');
        $writer->writeAttribute('weight', $this->getWeight());
        $writer->endElement();

        $writer->startElement('monetary_values');
        $writer->writeElement('item_value', '');
        $writer->endDocument();

        $writer->endElement();
        $writer->endElement();

        $writer->endElement();

        echo $writer->outputMemory();
        exit;

        return $writer->outputMemory();

        /*
        builder = ::Nokogiri::XML::Builder.new(encoding: 'UTF-8') do |xml|
                  xml.root do
                    xml.partner account_courier.username
                    xml.interchange(msg_type: "elsinfov1") do
                      xml.header(file_id: Time.now.strftime('%Y%m%d%H%M%S'), sender_cd: account_courier.username)
                      xml.item_list do
                        shipment.parcels.each do |parcel|
                          xml.item(item_params) do

                            xml.measures(weight: shipment.weight)

                            xml.monetary_values do
                              xml.values(code: "item_value", amount: shipment.cod_amount)
                            end if shipment.cod?

                            xml.account account_courier.account.bank_account if shipment.cod?

                            xml.comment_ shipment.remark if shipment.remark?
                            xml.partnerId parcel.id_for_external_system

                            xml.receiverAddressee do
                              xml.person_name shipment.receiver.name
                              xml.mobile shipment.receiver.phone if shipment.receiver.phone.present?
                              xml.email shipment.receiver.email if shipment.receiver.email.present?

                              if shipment.receiver.parcel_terminal
                                xml.address(offloadPostcode: shipment.receiver.parcel_terminal.identifier,
                                            country: shipment.receiver.country.code)
                              else
                                xml.address(postcode: formatted_postal_code(shipment.receiver),
                                        deliverypoint: shipment.receiver.city,
                                        street: shipment.receiver.street,
                                        country: shipment.receiver.country.code)
                              end
                            end

                            address = return_address ? return_address : shipment.sender

                            xml.returnAddressee do
                              xml.person_name address.name
                              xml.phone address.phone
                              xml.address(postcode: formatted_postal_code(address),
                                      deliverypoint: address.city,
                                      country: address.country.code,
                                      street: address.street)
                            end

                            xml.onloadAddressee do
                              xml.person_name shipment.sender.name
                              xml.phone shipment.sender.phone
                              xml.email shipment.sender.email
                              xml.address(postcode: formatted_postal_code(shipment.sender),
                                      deliverypoint: shipment.sender.city,
                                      street: shipment.sender.street,
                                      country: shipment.sender.country.code)
                            end if shipment.sender.id != address.id
                          end
                        end
                      end
                    end
                  end
                end
         */
    }
}
