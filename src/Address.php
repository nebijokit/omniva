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

    /**
     * @param string $name
     * @return Address
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $phone
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $email
     * @return Address
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function hasEmail()
    {
        return is_string($this->email);
    }

    /**
     * @param string $code
     * @return Address
     */
    public function setCountryCode($code)
    {
        $this->country = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->country;
    }

    /**
     * @param string $terminal
     * @return Address
     */
    public function setTerminal($terminal)
    {
        trigger_error('This method will removed 1.0. Use setPickupPoint() instead.', E_USER_DEPRECATED);
        $this->terminal = $terminal;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasTerminal()
    {
        trigger_error('This method will removed 1.0. Use hasPickupPoint() instead.', E_USER_DEPRECATED);
        return is_string($this->terminal);
    }

    /**
     * @return null|string
     */
    public function getTerminal()
    {
        trigger_error('This method will removed 1.0. Use getPickupPoint() instead.', E_USER_DEPRECATED);
        return $this->terminal;
    }

    /**
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $code
     * @return Address
     */
    public function setPostCode($code)
    {
        $this->postcode = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostCode()
    {
        return $this->postcode;
    }

    /**
     * @param PickupPoint $point
     * @return Address
     */
    public function setPickupPoint($point)
    {
        $this->pickupPoint = $point;
        return $this;
    }

    /**
     * @return null|PickupPoint
     */
    public function getPickupPoint()
    {
        return $this->pickupPoint;
    }
}
