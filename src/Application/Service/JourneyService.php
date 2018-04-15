<?php

namespace App\Application\Service;

use App\Domain\Entity\Journey;
use App\Domain\Entity\Route;

class JourneyService
{
    /**
     * @param Route[] $routes
     * @return Journey
     */
    public function request(array $routes): Journey
    {
        return new Journey($routes);
    }
}