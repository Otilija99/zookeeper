<?php

namespace ZooKeeper\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZooKeeper\ZooKeeper;
class FeedAnimalCommand extends Command
{
    protected static $defaultName = 'animal:feed';
    private $zooKeeper;

    public function __construct(ZooKeeper $zooKeeper)
    {
        $this->zooKeeper = $zooKeeper;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Feed an animal.')
            ->addArgument('animal', InputArgument::REQUIRED, 'The name of the animal.')
            ->addArgument('food', InputArgument::REQUIRED, 'The type of food.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $animalName = $input->getArgument('animal');
        $food = $input->getArgument('food');

        $animal = $this->zooKeeper->getAnimal($animalName);

        if ($animal) {
            $animal->feed($food);
            $status = $animal->getStatus();
            $output->writeln("Fed {$animalName}. Happiness: {$status['happiness']}, Food Reserve: {$status['foodReserve']}");
        } else {
            $output->writeln("Animal {$animalName} not found.");
        }

        return Command::SUCCESS;
    }
}
