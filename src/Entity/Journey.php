<?php

namespace App\Entity;

use App\Service\JourneyPriceCalculator;
use DateTimeImmutable;

class Journey
{
    const CANCELED = "canceled";
    const IN_SEARCH = "in_search";
    const FIXED = "fixed";
    const PROCESSING = "processing";
    const FINISHED = "finished";

    /**
     * @var string
     */
    private $status;

    /**
     * Person who canceled a journey
     * @var
     */
    private $cancelInitiator;

    /**
     * Driver
     * @var
     */
    private $driver;

    /**
     * @var
     */
    private $price;

    /**
     * @var
     */
    private $startedAt;

    /**
     * @var
     */
    private $finishedAt;

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
        $this->price = (new JourneyPriceCalculator($routes))->get();
    }

    /**
     * @param Driver $driver
     */
    public function apply(Driver $driver)
    {
        $this->status = self::FIXED;
        $this->driver = $driver;
    }

    /**
     *
     */
    public function finish()
    {
        $this->status = self::FINISHED;
        $this->price = "";
    }

    /**
     * @param $initiator
     */
    public function cancel($initiator)
    {
        $this->status = self::CANCELED;
        $this->cancelInitiator = $initiator;
    }

    /**
     *
     */
    public function start()
    {
        $this->status = self::PROCESSING;
        $this->startedAt = new DateTimeImmutable("now");
    }
}
