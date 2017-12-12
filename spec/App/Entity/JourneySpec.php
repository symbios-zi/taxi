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
    public function it_is_initializable()
    {
        $newJourney = $this->generateNewJourney();
    }

    protected function generateNewJourney()
    {
        $point = new Location(55.800857, 49.106190);
        $destination = new Location(55.780689, 49.135894);
        $passenger = new Passenger("Ivan", "+79990001111");

        return new Journey($passenger, $point, $destination);
    }


    public function it_is_driver_gets_a_journey()
    {
        $newJourney = $this->generateNewJourney();
        $driver = new Driver("Andrey", "Toyota Corolla", "+79992222222");
        $newJourney->apply($driver);

        $newJourney->start();
        var_dump($newJourney);
    }

}
