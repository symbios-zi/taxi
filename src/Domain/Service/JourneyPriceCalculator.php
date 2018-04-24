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
    private $bookingFee = 50;

    /**
     * @var int
     */
    private $pricePerMinute = 8;

    /**
     * @var int
     */
    private $pricePerKilometer = 5;

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
     * @param Route $route
     * @return float|int
     */
    public function applyFormula(Route $route)
    {
        return $this->bookingFee +
            $route->distance * $this->pricePerKilometer +
            $route->duration * $this->pricePerMinute;
    }
}