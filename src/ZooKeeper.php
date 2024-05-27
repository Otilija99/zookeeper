<?php

namespace ZooKeeper;

class ZooKeeper
{
    private $animals;

    public function __construct()
    {
        $this->animals = [];
    }

    public function addAnimal($name, $foodType)
    {
        $this->animals[$name] = new Animal($name, $foodType);
    }

    public function getAnimal($name)
    {
        return $this->animals[$name] ?? null;
    }

    public function listAnimals()
    {
        return array_keys($this->animals);
    }
}
