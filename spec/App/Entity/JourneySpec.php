<?php

namespace spec\App\Entity;

use App\Entity\Driver;
use App\Entity\Passenger;
use App\Entity\Location;
use PhpSpec\ObjectBehavior;

class JourneySpec extends ObjectBehavior
{
    public function let()
    {
        $point = new Location(55.800857, 49.106190);
        $destination = new Location(55.825737, 49.131295);
        $passenger = new Passenger("Ivan", "+79990001111");

        $this->beConstructedWith($passenger, $point, $destination);
    }

    public function it_is_driver_gets_a_journey()
    {
        $this->getEstimatedPrice();

        $driver = new Driver("Andrey", "Toyota Corolla", "+79992222222");
        $this->apply($driver);
        $this->start();
    }

}
