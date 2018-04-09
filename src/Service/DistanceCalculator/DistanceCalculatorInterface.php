<?php

namespace App\Service\DistanceCalculator;


use App\Entity\Location;
use App\Entity\Route;

interface DistanceCalculatorInterface
{
    /**
     * Returns routes collection
     * @param Location $point
     * @param Location $destination
     * @return Route[]
     */
    public function getRoutes(Location $point, Location $destination): array;
}