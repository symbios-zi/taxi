<?php

namespace App\ValueObject;

use InvalidArgumentException;

class Location
{
    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $latitude;

    /**
     * Location constructor.
     * @param $longitude
     * @param $latitude
     */
    public function __construct(float $longitude, float $latitude)
    {

        if( ! preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/', $latitude)) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid latitude', $latitude));
        }

        $this->latitude = $latitude;

        if( ! preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/', $longitude)) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid longitude', $longitude));
        }

        $this->longitude = $longitude;
    }

    public function latitude()
    {
        return $this->latitude;
    }

    public function longitude()
    {
        return $this->longitude;
    }

    public function __toString()
    {
        return $this->latitude . ' ' . $this->longitude;
    }


}