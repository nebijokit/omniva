<?php

namespace spec\Omniva;

use PhpSpec\ObjectBehavior;
use Omniva\Address;

class AddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Address::class);
    }

    public function it_should_have_name()
    {
        $name = 'name surname';

        $this->setName($name)->shouldHaveType(Address::class);
        $this->getName()->shouldReturn($name);
    }

    public function it_should_have_phone()
    {
        $mobile = '+37060000000';

        $this->setPhone($mobile)->shouldHaveType(Address::class);
        $this->getPhone()->shouldReturn($mobile);
    }

    public function it_should_have_email()
    {
        $email = 'ab@nebijokit.lt';

        $this->hasEmail()->shouldReturn(false);
        $this->setEmail($email)->shouldHaveType(Address::class);
        $this->hasEmail()->shouldReturn(true);
        $this->getEmail()->shouldReturn($email);
    }

    public function it_should_have_country_code()
    {
        $code = 'LT';

        $this->setCountryCode($code)->shouldHaveType(Address::class);
        $this->getCountryCode()->shouldReturn($code);
    }

    public function it_should_have_terminal_identifier()
    {
        $identifier = '88822';

        $this->hasTerminal()->shouldReturn(false);
        $this->setTerminal($identifier)->shouldHaveType(Address::class);
        $this->hasTerminal()->shouldReturn(true);
        $this->getTerminal()->shouldReturn($identifier);
    }

    public function it_should_have_city()
    {
        $city = 'Vilnius';

        $this->setCity($city)->shouldHaveType(Address::class);
        $this->getCity()->shouldReturn($city);
    }

    public function it_should_have_street()
    {
        $street = 'Konstitucijos pr. 8';

        $this->setStreet($street)->shouldHaveType(Address::class);
        $this->getStreet()->shouldReturn($street);
    }

    public function it_should_have_postcode()
    {
        $code = '00000';

        $this->setPostCode($code)->shouldHaveType(Address::class);
        $this->getPostCode()->shouldReturn($code);
    }
}
