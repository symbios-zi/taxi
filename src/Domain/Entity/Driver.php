<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="drivers")
 */
class Driver
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $car;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Journey", mappedBy="driver")
     */
    private $journeys;

    /**
     * Driver constructor.
     * @param string $name
     * @param string $car
     * @param string $phone
     */
    public function __construct(string $name, string $car, string $phone)
    {
        $this->name = $name;
        $this->car = $car;
        $this->phone = $phone;
    }
}
