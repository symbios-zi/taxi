<?php

namespace spec\App\Entity;

use App\Entity\Driver;
use App\Entity\Journey;
use App\Entity\Passenger;
use App\ValueObject\Location;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JourneySpec extends ObjectBehavior
{
    public function let()
    {
        $point = new Location(55.800857, 49.106190);
        $destination = new Location(55.780689, 49.135894);
        $passenger = new Passenger("Ivan", "+79990001111");

        $this->beConstructedWith($passenger, $point, $destination);
    }

    public function it_is_driver_gets_a_journey()
    {
        $driver = new Driver("Andrey", "Toyota Corolla", "+79992222222");
        $this->apply($driver);
        $this->start();
    }

}
