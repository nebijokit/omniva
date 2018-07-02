<?php

namespace spec\Omniva;

use Omniva\Parcel;
use Omniva\Service;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParcelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Parcel::class);
    }

    public function it_should_allow_to_set_username()
    {
        $username = 'string';
        $this->setUsername($username)->shouldHaveType(Parcel::class);

        $this->getUsername()->shouldReturn($username);
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
        $this->setComment($comment)->shouldHaveType(Parcel::class);
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

        $this->addService($sms)->shouldHaveType(Parcel::class);
        $this->getServices()->count()->shouldReturn(1);

        $this->addService($cod)->shouldHaveType(Parcel::class);
        $this->getServices()->count()->shouldReturn(2);
    }
}
