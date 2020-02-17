<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\{DemandeManager, UserManager, DailyFactureManager, CommandeManager};
use App\Entity\DailyFacture;

class UpdateEtatDemandeCommand extends Command
{
    protected static $defaultName = "app:update:etat-demande";
    protected $demandeManager;

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Update Status Demande')
        ->setHelp('This command allows you to update status of Demande in database...');

    }

    public function __construct(bool $requirePassword = false ,DemandeManager $demandeManager, CommandeManager $commandeManager)
    {
        $this->demandeManager = $demandeManager;
        $this->commandeManager = $commandeManager;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Etat Demande loadding',
            '============',
            '',
        ]);

        $this->commandeManager->updateEtatDemande();

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a facture journalier.');
    }
}