<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\TransactionManager;

class UpdateTransactionDateCommand extends Command
{
    protected static $defaultName = "app:transaction:date-update";
    protected $userManager;

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('generate date for transaction without date create')

        // all command is :
        // php bin/console app:email:relance ==> tout les heures
        // php bin/console app:email:relance --option=1 ==> tout les jours à 10h le matin
        // php bin/console app:email:relance --option=2 ==> tout les jours à 10h le matin

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a date of transaction withoute date create...')
        ->addOption(
            "option",
            null,
            InputOption::VALUE_REQUIRED,
            'option or relance level',
            0
            )
        ;
    }

    public function __construct(bool $requirePassword = false, TransactionManager $transactionManager)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->requirePassword = $requirePassword;
        $this->transactionManager = $transactionManager;

        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Date Transaction loadding',
            '============',
            '',
        ]);

        $this->transactionManager->generateDateCreateForTransaction();
        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a date for all transaction relance.');
        $output->writeln([
            ' ',
            '============',
            'End',
        ]);
    }
}