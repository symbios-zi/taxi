<?php

namespace App\Domain\Entity;


class Driver
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $car;

    /**
     * @var string
     */
    private $phone;

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
