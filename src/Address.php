<?php

declare(strict_types=1);

namespace Omniva;

class Address
{
    /**
     * name & surname
     */
    private string $name;

    /**
     * phone number
     */
    private ?string $phone = null;

    private ?string $email = null;

    /**
     * country code (ISO code 2 letters)
     */
    private string $country;

    /**
     * terminal identifier
     */
    private ?string $terminal = null;

    private string $city;

    private string $street;

    private string $postcode;

    private ?PickupPoint $pickupPoint = null;

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

    public function getEmail(): ?string
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

    public function setPickupPoint(PickupPoint $point): static
    {
        $this->pickupPoint = $point;

        return $this;
    }

    public function getPickupPoint(): ?PickupPoint
    {
        return $this->pickupPoint;
    }
}
