<?php

namespace App\Entity;


class Route
{
    /**
     * @var float
     */
    public $distance;

    /**
     * @var float
     */
    public $duration;

    /**
     * @var Location
     */
    private $point;

    /**
     * @var Location
     */
    private $destination;

    /**
     * Route constructor.
     * @param Location $point
     * @param Location $destination
     * @param $distance
     * @param $duration
     */
    public function __construct(
        Location $point,
        Location $destination,
        float $distance,
        float $duration
    ) {
        $this->point = $point;
        $this->destination = $destination;
        $this->distance = $distance;
        $this->duration = $duration;
    }


}