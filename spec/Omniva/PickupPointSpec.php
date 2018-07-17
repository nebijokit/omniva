<?php

namespace spec\Omniva;

use Omniva\PickupPoint;
use PhpSpec\ObjectBehavior;

class PickupPointSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(00000);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PickupPoint::class);
    }

    public function it_should_allow_to_set_type()
    {
        $this->getType()->shouldReturn(null);
        $this->setType(PickupPoint::TYPE_TERMINAL)->shouldHaveType(PickupPoint::class);

        $this->getType()->shouldReturn(PickupPoint::TYPE_TERMINAL);
    }

    public function it_should_have_type_post_office()
    {
        $this->setType(PickupPoint::TYPE_POST_OFFICE);

        $this->isPostOffice()->shouldReturn(true);
    }

    public function it_should_have_type_terminal()
    {
        $this->setType(PickupPoint::TYPE_TERMINAL);

        $this->isTerminal()->shouldReturn(true);
    }

    public function it_should_throw_exception_when_type_is_empty()
    {
        $this->getType()->shouldReturn(null);

        $this->shouldThrow('\RuntimeException')->duringIsPostOffice();
    }

    public function it_should_not_allow_to_set_invalid_type()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetType(2);
    }

    public function it_should_allow_to_set_identifier()
    {
        $id = '88888';
        $this->setIdentifier($id)->shouldHaveType(PickupPoint::class);
        $this->getIdentifier()->shouldReturn($id);
    }
}
