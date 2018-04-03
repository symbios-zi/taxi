<?php

namespace spec\App\Entity;

use App\Entity\Passenger;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PassengerSpec extends ObjectBehavior
{
    public function let()
    {
        $name = "Konstantin";
        $phone = "+7937777777";

        $this->beConstructedWith($name, $phone);
    }
}
