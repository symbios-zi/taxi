<?php

namespace App\Domain\Entity;

use App\Domain\Service\JourneyPriceCalculator;
use DateTimeImmutable;

class EstimatedJourney
{

    /**
     * @var float
     */
    public $price;

    /**
     * @var float
     */
    public $duration;

    /**
     * @var float
     */
    public $distance;

    /**
     * @var Route[]|array
     */
    private $routes;


    /**
     * Journey constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->price = $this->calculatePrice($routes);
        $this->duration = $this->sumDurations();
        $this->distance = $this->sumDistances();
    }

    /**
     * @return float
     */
    private function sumDurations(): float
    {
        $durationsSum = 0;

        foreach($this->routes as $route) {
            $durationsSum += $route->duration;
        }

        return $durationsSum;
    }

    /**
     * @return float
     */
    private function sumDistances(): float
    {
        $distancesSum = 0;

        foreach($this->routes as $route) {
            $distancesSum += $route->distance;
        }

        return $distancesSum;
    }

    /**
     * @param array $routes
     * @return float|null
     */
    public function calculatePrice(array $routes): ?float
    {
        return (new JourneyPriceCalculator($routes))->get();
    }
}
