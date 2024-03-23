<?php

declare(strict_types=1);

namespace Omniva;

use ArrayIterator;

class Parcel
{
    /**
     * weight in kilograms
     */
    private float $weight;

    /**
     * @var ArrayIterator<int, Service>
     */
    private readonly \ArrayIterator $services;

    /**
     * amount in euros
     */
    private ?float $codAmount = null;

    /**
     * bank account number (IBAN)
     */
    private string $bankAccount;

    private ?string $comment = null;
    private string $partnerId;

    private Address $receiver;
    private Address $returnee;
    private Address $sender;

    private ?string $trackingNumber = null;

    public function __construct()
    {
        $this->services = new ArrayIterator();
    }

    /**
     * in grams
     */
    public function setWeight(float $weight): static
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

    public function hasComment(): bool
    {
        return ! is_null($this->comment);
    }

    public function getComment(): ?string
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

    public function getCodAmount(): ?float
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

    public function hasServices(): bool
    {
        return $this->services->count() > 0;
    }

    public function addService(Service $service): self
    {
        $this->services->append($service);

        return $this;
    }

    /**
     * @return ArrayIterator<int, Service>
     */
    public function getServices(): ArrayIterator
    {
        return $this->services;
    }

    public function setSender(Address $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getSender(): Address
    {
        return $this->sender;
    }

    public function setReceiver(Address $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getReceiver(): Address
    {
        return $this->receiver;
    }

    public function setReturnee(Address $returnee): self
    {
        $this->returnee = $returnee;

        return $this;
    }

    public function getReturnee(): Address
    {
        return $this->returnee;
    }

    public function hasTrackingNumber(): bool
    {
        return ! is_null($this->trackingNumber);
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $number): self
    {
        $this->trackingNumber = $number;

        return $this;
    }
}
