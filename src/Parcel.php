<?php

namespace Omniva;

use Omniva\Service;
use Omniva\Address;
use ArrayIterator;

class Parcel
{
    /**
     * weight in kilograms
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

    private $receiver;
    private $returnee;
    private $sender;

    private $trackingNumber;

    public function __construct()
    {
        $this->services = new ArrayIterator();
    }

    /**
     * in grams
     * @param float $weight
     * @return Parcel
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $comment
     * @return Parcel
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasComment()
    {
        return !is_null($this->comment);
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $partnerId
     * @return Parcel
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * @param float $amount
     * @return Parcel
     */
    public function setCodAmount($amount)
    {
        $this->codAmount = $amount;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCodAmount()
    {
        return $this->codAmount;
    }

    /**
     * @param string $number
     * @return Parcel
     */
    public function setBankAccount($number)
    {
        $this->bankAccount = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @return bool
     */
    public function hasServices()
    {
        return $this->services->count() > 0;
    }

    /**
     * @param \Omniva\Service $service
     * @return Parcel
     */
    public function addService($service)
    {
        $this->services->append($service);
        return $this;
    }

    /**
     * @return ArrayIterator
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param \Omniva\Address $sender
     * @return Parcel
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return \Omniva\Address
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param \Omniva\Address $receiver
     * @return Parcel
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @return \Omniva\Address
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param \Omniva\Address $returnee
     * @return Parcel
     */
    public function setReturnee($returnee)
    {
        $this->returnee = $returnee;
        return $this;
    }

    /**
     * @return Address
     */
    public function getReturnee()
    {
        return $this->returnee;
    }

    /**
     * @return bool
     */
    public function hasTrackingNumber()
    {
        return !is_null($this->trackingNumber);
    }

    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * @param string $number
     * @return Parcel
     */
    public function setTrackingNumber($number)
    {
        $this->trackingNumber = $number;
        return $this;
    }
}
