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

        $this->beConstructedWith($point, $destination);
    }

    public function it_is_driver_gets_a_journey()
    {
        $driver = new Driver("Andrey", "Toyota Corolla", "+79992222222");
        $this->apply($driver);
        $this->start();
    }

}
