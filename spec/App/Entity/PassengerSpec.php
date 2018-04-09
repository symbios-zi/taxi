<?php

namespace spec\App\Entity;

use App\Entity\Location;
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

    public function it_is_a_passenger_request_a_journey()
    {
        $point = new Location(55.800857, 49.106190);
        $destination = new Location(55.825737, 49.131295);
        $journeyInformation = $this->requestJourney($point, $destination);
        $journeyInformation->getEstimatedPrice();
    }

}
