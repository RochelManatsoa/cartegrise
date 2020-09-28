<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\CommandeManager;

class GenerateFactureCommand extends Command
{
    protected static $defaultName = "app:generate:facture";
    protected $commandeManager;

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Generate facture for one commande')

        // all command is :
        // php bin/console app:email:relance --id={commande} ==> id de la commande

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a email relance for user don\'t payed in application...')
        ->addOption(
            "id",
            null,
            InputOption::VALUE_REQUIRED,
            'option or relance level',
            0
            )
        ;
    }

    public function __construct(bool $requirePassword = false, CommandeManager $commandeManager)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->requirePassword = $requirePassword;
        $this->commandeManager = $commandeManager;

        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Generate facture loading',
            '============',
            '',
        ]);
        $option = (int) $input->getOption('id');

        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
        // $output->writeln($this->someMethod());

        // outputs a message followed by a "\n"
        // $output->writeln('Whoa!');
        $this->commandeManager->generateFactureCommande($option);
        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('generate a facture.');
    }
}