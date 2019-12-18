<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\{DemandeManager, UserManager, DailyFactureManager, CommandeManager};
use App\Entity\DailyFacture;

class FactureJournalierCommand extends Command
{
    protected static $defaultName = "app:facture:relance";
    protected $userManager;
    protected $commandeManager;
    protected $dailyFactureManager;

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a facture daily ...')

        // all command is :
        // php bin/console app:email:relance ==> tout les heures
        // php bin/console app:email:relance --option=1 ==> tout les jours à 10h le matin
        // php bin/console app:email:relance --option=2 ==> tout les jours à 10h le matin

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a email relance for user don\'t payed in application...');
        // ->addOption(
        //     "option",
        //     null,
        //     InputOption::VALUE_REQUIRED,
        //     'option or relance level',
        //     0
        //     )
        // ;
    }

    public function __construct(bool $requirePassword = false ,DailyFactureManager $dailyFactureManager, DemandeManager $demandeManager, CommandeManager $commandeManager, UserManager $userManager)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->demandeManager = $demandeManager;
        $this->commandeManager = $commandeManager;
        $this->userManager = $userManager;
        $this->dailyFactureManager = $dailyFactureManager;

        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'facture daily loadding',
            '============',
            '',
        ]);

        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
        // $output->writeln($this->someMethod());

        // outputs a message followed by a "\n"
        // $output->writeln('Whoa!');
        $now = new \DateTime();
        // $demandes = $this->demandeManager->getDailyDemandeFacture($now);
        $commandes = $this->commandeManager->getDailyCommandeFacture($now);
        // $file = $this->demandeManager->generateDailyFacture($demandes, $now);
        $file = $this->commandeManager->generateDailyFacture($commandes, $now);
        $dailyFacture = $this->dailyFactureManager->init();
        $dailyFacture->setDateCreate($now);
        $dailyFacture->setPath($file);
        $this->dailyFactureManager->save($dailyFacture);
        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a facture journalier.');
    }
}