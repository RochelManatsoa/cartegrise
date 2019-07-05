<?php

namespace App\Manager;

use SwiftMailer;
use App\Manager\UserManager;

class EmailRelanceManager
{
    protected $mailer;
    protected $userManager;
    public function __construct(
        SwiftMailer $mailer,
        UserManager $userManager
    )
    {
        $this->mailer = $mailer;
        $this->userManager = $userManager;
    }

    public function checkMailRelance()
    {
        $users = $this->userManager->findUserForRelance();
        dd($users);
    }
}