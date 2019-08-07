<?php

namespace App\Command;

use App\Entity\Departement;
use League\Csv\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DepartementCommand extends Command
{
    protected static $defaultName = 'app:departement';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting to import the feed ...');

        $csv = Reader::createFromPath('%kernel.project_dir%/../public/download/departement.csv', 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        $result = $csv->getContent();
        $lines = explode("\n",$result);
        $departement = [];

        foreach($lines as $k => $line){
            $line = explode(",", $line);
            $dep = new Departement();
            $dep->setName($line[2]);
            $dep->setCode($line[1]);
            $dep->setCodeDep($line[1].' - '.$line[2]);
            $departement[$line[2]] = $dep; 
            $this->em->persist($dep);
            $this->em->flush();
        }

        $io->success('départements importés');
    }
}
