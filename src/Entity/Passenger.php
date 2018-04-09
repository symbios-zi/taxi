<?php

namespace App\Entity;

class Passenger
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $phone;

    /**
     * Passenger constructor.
     * @param string $name
     * @param string $phone
     */
    public function __construct(string $name, string $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    /**
     * @param Location $point
     * @param Location $destination
     * @return Journey
     */
    public function requestJourney(Location $point, Location $destination)
    {
        return (new Journey($point, $destination));

    }

    /**
     * @param Location $point
     * @param Location $destination
     */
    public function orderJourney(Location $point, Location $destination)
    {
         (new Journey($point, $destination))->start();
    }


}
