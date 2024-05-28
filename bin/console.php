#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\Console\Application;
use ZooKeeper\ZooKeeper;
use ZooKeeper\Command\FeedAnimalCommand;
use ZooKeeper\Command\ListAnimalsCommand;
use ZooKeeper\Command\InteractAnimalCommand;

$zooKeeper = new ZooKeeper();
$zooKeeper->addAnimal('Lion', 'Meat');
$zooKeeper->addAnimal('Elephant', 'Vegetables');
$zooKeeper->addAnimal('Monkey', 'Fruits');
$zooKeeper->addAnimal('Penguin', 'Fish');
$zooKeeper->addAnimal('Chicken', 'Grains');

$application = new Application();
$application->add(new FeedAnimalCommand($zooKeeper));
$application->add(new ListAnimalsCommand($zooKeeper));
$application->add(new InteractAnimalCommand($zooKeeper));
$application->run();
