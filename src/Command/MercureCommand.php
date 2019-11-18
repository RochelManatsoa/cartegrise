<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MercureCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:mercure:relance';

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a new mercure server.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a mercure server...');
    }


    public function __construct(bool $requirePassword = false)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('server Mercure in process!');
        exec("JWT_KEY='aVerySecretKey' ADDR='localhost:3000' ALLOW_ANONYMOUS=1 CORS_ALLOWED_ORIGINS=* ./mercure/macbook/mercure 2>&1");
        $output->writeln('Success!');
        // ...
    }
}