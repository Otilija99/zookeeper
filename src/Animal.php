<?php

namespace ZooKeeper;
class Animal
{
    private $name;
    private $happiness;
    private $foodType;
    private $foodReserve;

    public function __construct($name, $foodType)
    {
        $this->name = $name;
        $this->happiness = 100; // default happiness
        $this->foodType = $foodType;
        $this->foodReserve = 100; // default food reserve
    }

    public function play()
    {
        $this->happiness += 10;
        $this->foodReserve -= 10;
    }

    public function work()
    {
        $this->happiness -= 10;
        $this->foodReserve -= 20;
    }

    public function feed($food)
    {
        if ($food === $this->foodType) {
            $this->foodReserve += 20;
            return "You fed {$this->name}.";
        } else {
            $this->happiness -= 10;
            $this->foodReserve -= 10;
            return "The animal does not eat that. Try {$this->foodType} instead.";
        }
    }

    public function pet()
    {
        $this->happiness += 5;
    }

    public function isTired()
    {
        return $this->foodReserve < 40;
    }

    public function getStatus()
    {
        return [
            'name' => $this->name,
            'happiness' => $this->happiness,
            'foodReserve' => $this->foodReserve,
        ];
    }
}
