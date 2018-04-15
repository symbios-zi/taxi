<?php

namespace App\Domain\Service;


use App\Domain\Entity\Route;

class JourneyPriceCalculator
{

    /**
     * @var array
     */
    private $routes = [];

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
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Calculates a price
     * @return float|int
     */
    public function get()
    {
        $price = 0;
        /** @var Route $route */
        foreach ($this->routes as $route) {
            $price += $this->applyFormula($route);
        }

        return $price;
    }

    /**
     * @param $route
     * @param $price
     * @return float|int
     */
    public function applyFormula(Route $route)
    {
        return  $route->distance * $this->pricePerDistance + $route->duration * $this->pricePerMinute;
    }
}