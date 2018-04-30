<?php

namespace App\Domain\Entity;

use App\Domain\Service\JourneyPriceCalculator;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="journeys")
 */
class Journey
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    const CANCELED   = "canceled";
    const IN_SEARCH  = "in_search";
    const FIXED      = "fixed";
    const PROCESSING = "processing";
    const FINISHED   = "finished";

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * Person who canceled a journey
     * @var
     */
    private $cancelInitiator;


    /**
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $finishedAt;

    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Passenger", inversedBy="journeys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $passenger;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Driver", inversedBy="journeys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

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
