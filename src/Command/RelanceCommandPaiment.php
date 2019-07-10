<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\{DemandeManager, MailManager};

class RelanceCommandPaiment extends Command
{
    protected static $defaultName = "app:email:relancePaiment";
    protected $demandeManager;
    protected $mailManager;

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a notification relace.')

        // all command is :
        // php bin/console app:email:relancePaiment ==> tout les heures
        // php bin/console app:email:relancePaiment --day=7 ==> tout les jours à 10h le matin
        // php bin/console app:email:relancePaiment --day=14 ==> tout les jours à 10h le matin
        // php bin/console app:email:relancePaiment --day=20 ==> tout les jours à 10h le matin
        // php bin/console app:email:relancePaiment --day=27 ==> tout les jours à 10h le matin

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a email relance for user don\'t payed in application...')
        ->addOption(
            "day",
            null,
            InputOption::VALUE_REQUIRED,
            'option or relance level',
            0
            )
        ;
    }

    public function __construct(bool $requirePassword = false, DemandeManager $demandeManager, MailManager $mailManager)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->requirePassword = $requirePassword;
        $this->demandeManager = $demandeManager;
        $this->mailManager = $mailManager;

        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Email relance loadding',
            '============',
            '',
        ]);
        $day = (int) $input->getOption('day');

        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
        // $output->writeln($this->someMethod());

        // outputs a message followed by a "\n"
        // $output->writeln('Whoa!');
        $this->demandeManager->getUserWithoutSendDocumentInDay($day, $this->mailManager);
        // $this->userManager->sendUserForRelance($option);
        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a email relance.');
    }
}