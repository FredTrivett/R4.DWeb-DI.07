<?php

namespace App\Command;

use App\Entity\Lego;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:populate-database',
    description: 'Populate the database with Lego data from a JSON file.',
)]
class PopulateDatabaseCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('jsonFile', InputArgument::REQUIRED, 'The path to the JSON file containing the Lego data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $jsonFilePath = $input->getArgument('jsonFile');

        if (!file_exists($jsonFilePath)) {
            $io->error('The specified JSON file does not exist.');
            return Command::FAILURE;
        }

        $jsonData = file_get_contents($jsonFilePath);
        $legoData = json_decode($jsonData, true);

        if (!$legoData) {
            $io->error('Error decoding JSON file.');
            return Command::FAILURE;
        }

        foreach ($legoData as $item) {
            $lego = new Lego();
            $lego->setName($item['name']);
            $lego->setDescription($item['description']);
            $lego->setPrice($item['price']);
            $lego->setPieces($item['pieces']);
            $lego->setBoxImage($item['images']['box']);
            $lego->setLegoImage($item['images']['bg']);

            $this->entityManager->persist($lego);
        }

        $this->entityManager->flush();
        $io->success('Lego data has been successfully imported into the database.');

        return Command::SUCCESS;
    }
}

// php bin/console app:populate-database src/data/data.json

// #[AsCommand(
//     name: 'app:populate-database',
//     description: 'Add a short description for your command',
// )]
// class PopulateDatabaseCommand extends Command
// {
//     public function __construct()
//     {
//         parent::__construct();
//     }

//     protected function configure(): void
//     {
//         $this
//             ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//             ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//         ;
//     }

//     protected function execute(InputInterface $input, OutputInterface $output): int
//     {
//         $io = new SymfonyStyle($input, $output);
//         $arg1 = $input->getArgument('arg1');

//         if ($arg1) {
//             $io->note(sprintf('You passed an argument: %s', $arg1));
//         }

//         if ($input->getOption('option1')) {
//             // ...
//         }

//         $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

//         return Command::SUCCESS;
//     }
// }
