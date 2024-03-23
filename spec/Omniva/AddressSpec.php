<?php

declare(strict_types=1);

namespace spec\Omniva;

use PhpSpec\ObjectBehavior;
use Omniva\Address;
use Omniva\PickupPoint;

class AddressSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Address::class);
    }

    public function it_should_have_name(): void
    {
        $name = 'name surname';

        $this->setName($name)->shouldHaveType(Address::class);
        $this->getName()->shouldReturn($name);
    }

    public function it_should_have_phone(): void
    {
        $mobile = '+37060000000';

        $this->setPhone($mobile)->shouldHaveType(Address::class);
        $this->getPhone()->shouldReturn($mobile);
    }

    public function it_should_have_email(): void
    {
        $email = 'ab@nebijokit.lt';

        $this->hasEmail()->shouldReturn(false);
        $this->setEmail($email)->shouldHaveType(Address::class);
        $this->hasEmail()->shouldReturn(true);
        $this->getEmail()->shouldReturn($email);
    }

    public function it_should_have_country_code(): void
    {
        $code = 'LT';

        $this->setCountryCode($code)->shouldHaveType(Address::class);
        $this->getCountryCode()->shouldReturn($code);
    }

    public function it_should_trigger_deprecation_when_setting_terminal(): void
    {
        $identifier = '88822';
        $this->shouldTrigger(E_USER_DEPRECATED)->duringSetTerminal($identifier);
    }

    public function it_should_trigger_deprecation_when_getting_terminal(): void
    {
        $this->shouldTrigger(E_USER_DEPRECATED)->duringGetTerminal();
    }

    public function it_should_trigger_deprecation_when_checking_whether_terminal_is_set(): void
    {
        $this->shouldTrigger(E_USER_DEPRECATED)->duringHasTerminal();
    }

    public function it_should_have_city(): void
    {
        $city = 'Vilnius';

        $this->setCity($city)->shouldHaveType(Address::class);
        $this->getCity()->shouldReturn($city);
    }

    public function it_should_have_street(): void
    {
        $street = 'Konstitucijos pr. 8';

        $this->setStreet($street)->shouldHaveType(Address::class);
        $this->getStreet()->shouldReturn($street);
    }

    public function it_should_have_postcode(): void
    {
        $code = '00000';

        $this->setPostCode($code)->shouldHaveType(Address::class);
        $this->getPostCode()->shouldReturn($code);
    }

    public function it_should_allow_to_set_pickup_point(PickupPoint $point): void
    {
        $this->setPickupPoint($point)->shouldHaveType(Address::class);
        $this->getPickupPoint()->shouldReturn($point);
    }
}
