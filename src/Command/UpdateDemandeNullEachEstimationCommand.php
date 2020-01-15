<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\{DemandeManager, CommandeManager};
use App\Entity\Demande;

class UpdateDemandeNullEachEstimationCommand extends Command
{
    protected static $defaultName = "app:update:estimation-demande";
    protected $demandeManager;
    protected $commandeManager;
    protected $mailManager;

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('update demandeId in commande relance.')
        ->setHelp('This command allows you to update the demandeId if exist in commande...')
        ->addOption(
            "day",
            null,
            InputOption::VALUE_REQUIRED,
            'option or relance level',
            0
            )
        ;
    }

    public function __construct(bool $requirePassword = false, DemandeManager $demandeManager,CommandeManager $commandeManager)
    {
        $this->requirePassword = $requirePassword;
        $this->demandeManager = $demandeManager;
        $this->CommandeManager = $commandeManager;

        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'commande update loadding',
            '============',
            '',
        ]);
        $day = (int) $input->getOption('day');
        $commandes = $this->CommandeManager->getCommandeWhoDemandeIsNull();
        foreach ($commandes as $commande) {
            $demande = $this->demandeManager->getDemandeForCommande($commande);
            if($demande instanceof Demande){
                $commande->setDemande($demande);
            }   
        }
        $output->write('======= ===== ====');
        $output->write('update commande finished');
    }
}