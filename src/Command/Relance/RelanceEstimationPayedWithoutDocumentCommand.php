<?php

namespace App\Command\Relance;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\Manager\{UserManager, CommandeManager, DemandeManager};
use App\Entity\{Commande, User};
use Symfony\Component\Console\Helper\ProgressBar;

class RelanceEstimationPayedWithoutDocumentCommand extends Command
{
    protected static $defaultName = "relance:notification:estimation-without-document";
    protected $userManager;
    /**
     * configure o
     *
     * @return void
     */
    protected function configure()
    {
        $this
        ->setDescription('Relance of notification no payed')
        ->setHelp('This command allow you to check the command no payed and send email in user about He must pay it')
        ;
    }

    /**
     * Constructor functoin 
     *
     * @param boolean $requirePassword
     * @param UserManager $userManager
     */
    public function __construct(bool $requirePassword = false, UserManager $userManager, DemandeManager $demandeManager)
    {
        $this->requirePassword = $requirePassword;
        $this->userManager = $userManager;
        $this->demandeManager = $demandeManager;

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
        $users = $this->demandeManager->getUserHaveDemandeButNoDocument();
        
        $progressBar = new ProgressBar($output, count($users));
        // loop the command and increment the count of relance
        foreach($users as $user) {
            // advances the progress bar 1 unit
            $progressBar->advance();
            $output->writeln('');
            if ($user['userID'] === null )continue;
            $demande = $this->demandeManager->find($user['demandeId']);
            $user = $this->userManager->find($user['userID']);
            
            if (!$user instanceof User) {
                continue;
            }
            // treatment of each commande
            $output->writeln('User id ==> ' . $user->getId());
            // send email
            $this->userManager->sendUserWithoutDocumentRelance($user, $demande);
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