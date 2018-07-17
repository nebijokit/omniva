<?php

namespace Omniva;

use Omniva\PickupPoint;

class Address
{
    /**
     * name & surname
     */
    private $name;

    /**
     * phone number
     */
    private $phone;

    private $email;

    /**
     * country code (ISO code 2 letters)
     */
    private $country;

    /**
     * terminal identifier
     */
    private $terminal;

    private $city;

    private $street;

    private $postcode;

    private $pickupPoint;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function hasEmail(): bool
    {
        return is_string($this->email);
    }

    public function setCountryCode(string $code): self
    {
        $this->country = $code;
        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->country;
    }

    public function setTerminal(string $terminal): self
    {
        trigger_error('This method will removed 1.0. Use setPickupPoint() instead.', E_USER_DEPRECATED);
        $this->terminal = $terminal;
        return $this;
    }

    public function hasTerminal(): bool
    {
        trigger_error('This method will removed 1.0. Use hasPickupPoint() instead.', E_USER_DEPRECATED);
        return is_string($this->terminal);
    }

    public function getTerminal(): ?string
    {
        trigger_error('This method will removed 1.0. Use getPickupPoint() instead.', E_USER_DEPRECATED);
        return $this->terminal;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setPostCode(string $code): self
    {
        $this->postcode = $code;
        return $this;
    }

    public function getPostCode(): string
    {
        return $this->postcode;
    }

    public function setPickupPoint(PickupPoint $point)
    {
        $this->pickupPoint = $point;
        return $this;
    }

    public function getPickupPoint(): ?PickupPoint
    {
        return $this->pickupPoint;
    }
}
