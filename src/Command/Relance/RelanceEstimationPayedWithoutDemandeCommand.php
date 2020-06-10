<?php

namespace App\Command\Relance;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\{UserManager, CommandeManager};
use App\Entity\{Commande, User};
use Symfony\Component\Console\Helper\ProgressBar;

class RelanceEstimationPayedWithoutDemandeCommand extends Command
{
    protected static $defaultName = "relance:notification:estimation-without-demande";
    protected $userManager;
    /**
     * configure o
     *
     * @return void
     */
    protected function configure()
    {
        $this
        ->setDescription('Relance of notification no demande entity')
        ->setHelp('This command allow you to check the command no demande and send email in user about He must pay it')
        ;
    }

    /**
     * Constructor functoin 
     *
     * @param boolean $requirePassword
     * @param UserManager $userManager
     */
    public function __construct(bool $requirePassword = false, UserManager $userManager, CommandeManager $commandeManager)
    {
        $this->requirePassword = $requirePassword;
        $this->userManager = $userManager;
        $this->commandeManager = $commandeManager;

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
        // get all command no payed to send email relance
        $users = $this->commandeManager->getUserWithoutDemandeButPayed();
        
        $progressBar = new ProgressBar($output, count($users));
        // loop the command and increment the count of relance
        foreach($users as $user) {
            // advances the progress bar 1 unit
            $progressBar->advance();
            $output->writeln('');
            if ($user['userID'] === null )continue;
            $commande = $this->commandeManager->find($user['commandeId']);
            $user = $this->userManager->find($user['userID']);
            
            if (!$user instanceof User) {
                continue;
            }
            // treatment of each commande
            $output->writeln('User id ==> ' . $user->getId());
            // send email
            $this->userManager->sendUserWithoutDemandeRelance($user, $commande);
            $output->writeln('email sended');
            // update the reminder of user
            $output->writeln('user updated');

        }

        // ensures that the progress bar is at 100%
        $progressBar->finish();
        $output->writeln('');
        $output->write('done');
    }
}