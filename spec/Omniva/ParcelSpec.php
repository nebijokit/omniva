<?php

namespace spec\Omniva;

use Omniva\Parcel;
use Omniva\Service;
use Omniva\Address;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParcelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Parcel::class);
    }

    public function it_should_allow_to_set_weight()
    {
        $weight = 120.0;
        $this->setWeight($weight)->shouldHaveType(Parcel::class);
        $this->getWeight()->shouldReturn($weight);
    }

    public function it_should_allow_to_set_comment()
    {
        $comment = 'comment';
        $this->hasComment()->shouldReturn(false);
        $this->setComment($comment)->shouldHaveType(Parcel::class);
        $this->hasComment()->shouldReturn(true);
        $this->getComment()->shouldReturn($comment);
    }

    public function it_should_allow_to_set_foreign_id()
    {
        $foreignId = 'order-1';
        $this->setPartnerId($foreignId)->shouldHaveType(Parcel::class);
        $this->getPartnerId()->shouldReturn($foreignId);
    }

    public function it_should_return_cod_amount()
    {
        $amount = 12.22;
        $this->getCodAmount()->shouldReturn(null);
        $this->setCodAmount($amount)->shouldHaveType(Parcel::class);
        $this->getCodAmount()->shouldReturn($amount);
    }

    public function it_should_have_bank_account()
    {
        $bank = 'LT000121';
        $this->setBankAccount($bank)->shouldHaveType(Parcel::class);
        $this->getBankAccount()->shouldReturn($bank);
    }

    public function it_should_be_possible_to_add_service()
    {
        $sms = Service::SMS();
        $cod = Service::COD();

        $this->hasServices()->shouldReturn(false);
        $this->addService($sms)->shouldHaveType(Parcel::class);
        $this->hasServices()->shouldReturn(true);
        $this->getServices()->count()->shouldReturn(1);

        $this->addService($cod)->shouldHaveType(Parcel::class);
        $this->hasServices()->shouldReturn(true);
        $this->getServices()->count()->shouldReturn(2);
    }

    public function it_should_have_address()
    {
        $address = new Address();
        $address
            ->setName('Karalius Mindaugas')
            ->setPhone('+37060000000')
            ->setCountryCode('LT')
            ->setCity('Vilnius')
            ->setStreet('Katedros a. 4')
            ->setPostCode('00000')
        ;

        $this->setSender($address)->shouldHaveType(Parcel::class);
        $this->getSender()->shouldReturn($address);

        $this->setReceiver($address)->shouldHaveType(Parcel::class);
        $this->getReceiver()->shouldReturn($address);

        $this->setReturnee($address)->shouldHaveType(Parcel::class);
        $this->getReturnee()->shouldReturn($address);
    }

    public function it_should_have_tracking_nubmer()
    {
        $number = 'AB0009213434LT';
        $this->hasTrackingNumber()->shouldReturn(false);

        $this->setTrackingNumber($number)->shouldHaveType(Parcel::class);

        $this->hasTrackingNumber()->shouldReturn(true);

        $this->getTrackingNumber()->shouldReturn($number);
    }
}
