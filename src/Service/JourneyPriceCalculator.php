<?php
/**
 * Created by PhpStorm.
 * User: symbios
 * Date: 04.04.18
 * Time: 0:02
 */

namespace App\Service;


class JourneyPriceCalculator
{

    /**
     * @var float
     */
    private $distance;

    /**
     * @var float
     */
    private $time;

    /**
     * @var int
     */
    private $pricePerMinute = 15;

    /**
     * @var int
     */
    private $pricePerDistance = 10;

    /**
     * JourneyPriceCalculator constructor.
     * @param $distance
     * @param $time
     */
    public function __construct(float $distance, float $time)
    {
        $this->distance = $distance;
        $this->time = $time;
    }

    /**
     * Calculates a price
     * @return float|int
     */
    public function getPrice()
    {
        return $this->distance * $this->pricePerDistance + $this->time * $this->pricePerMinute;
    }
}