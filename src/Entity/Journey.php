<?php

namespace App\Entity;

use App\Entity\Location;
use App\Service\DistanceManager;
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
    private $point;

    /**
     * @var string
     */
    private $destination;

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
     * Passenger
     * @var
     */
    private $passenger;

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
     * Journey constructor.
     * @param Passenger $passenger
     * @param \App\Entity\Location $point
     * @param \App\Entity\Location $destination
     */
    public function __construct(Passenger $passenger, Location $point, Location $destination)
    {
        $this->passenger = $passenger;
        $this->point = $point;
        $this->destination = $destination;
        $this->status = self::IN_SEARCH;
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

    public function getEstimatedPrice()
    {
        return (new DistanceManager())->getDrivingDistance($this->point, $this->destination);
        //return (new JourneyPriceCalculator($distance, $time))->getPrice();
    }
}
