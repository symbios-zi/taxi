<?php

namespace App\Entity;

use App\ValueObject\Location;
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

    public function __construct(Passenger $passenger, Location $point, Location $destination)
    {
        $this->passenger = $passenger;
        $this->point = (string) $point;
        $this->destination = (string) $destination;
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
}
