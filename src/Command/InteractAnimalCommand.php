<?php

namespace ZooKeeper\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use ZooKeeper\ZooKeeper;

class InteractAnimalCommand extends Command
{
    protected static $defaultName = 'animal:interact';
    private $zooKeeper;
    private $foods = ['Meat', 'Vegetables', 'Fruits', 'Fish', 'Grains'];

    public function __construct(ZooKeeper $zooKeeper)
    {
        $this->zooKeeper = $zooKeeper;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Interact with an animal.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        while (true) {
            // Ask for the animal name
            $animalQuestion = new ChoiceQuestion(
                'Select an animal to interact with:',
                $this->zooKeeper->listAnimals()
            );
            $animalName = $helper->ask($input, $output, $animalQuestion);
            $animal = $this->zooKeeper->getAnimal($animalName);

            if (!$animal) {
                $output->writeln("Animal {$animalName} not found.");
                continue;
            }

            // Ask for the action to perform
            $actionQuestion = new ChoiceQuestion(
                'What would you like to do?',
                ['Feed', 'Play', 'Check Status']
            );
            $action = $helper->ask($input, $output, $actionQuestion);

            switch ($action) {
                case 'Feed':
                    $foodQuestion = new ChoiceQuestion(
                        'Select the type of food:',
                        $this->foods
                    );
                    $food = $helper->ask($input, $output, $foodQuestion);
                    $result = $animal->feed($food);
                    $output->writeln($result);
                    break;

                case 'Play':
                    $animal->play();
                    $output->writeln("You played with {$animalName}. Current status:");
                    if ($animal->isTired()) {
                        $output->writeln("{$animalName} is getting tired. Food Reserve is below 40.");
                    }
                    break;

                case 'Check Status':
                    $output->writeln("Current status of {$animalName}:");
                    break;
            }

            // Display the current status
            $status = $animal->getStatus();
            $output->writeln("Happiness: {$status['happiness']}, Food Reserve: {$status['foodReserve']}");

            // Ask if the user wants to continue
            $continueQuestion = new ChoiceQuestion(
                'Do you want to continue?',
                ['Yes', 'No'],
                0
            );
            $continue = $helper->ask($input, $output, $continueQuestion);

            if ($continue === 'No') {
                break;
            }
        }

        return Command::SUCCESS;
    }
}
