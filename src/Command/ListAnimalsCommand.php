<?php

namespace ZooKeeper\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZooKeeper\ZooKeeper;

class ListAnimalsCommand extends Command
{
    protected static $defaultName = 'animal:list';
    private $zooKeeper;

    public function __construct(ZooKeeper $zooKeeper)
    {
        $this->zooKeeper = $zooKeeper;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('List all animals in the zoo.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Animals in the zoo:");

        foreach ($this->zooKeeper->listAnimals() as $animalName) {
            $animal = $this->zooKeeper->getAnimal($animalName);
            $status = $animal->getStatus();
            $output->writeln("{$animalName} - Happiness: {$status['happiness']}, Food Reserve: {$status['foodReserve']}");
        }

        return Command::SUCCESS;
    }
}
