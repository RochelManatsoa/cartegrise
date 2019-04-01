<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Entity\User;
use App\Manager\UserManager;

class AppExtension extends AbstractExtension
{
    private $demandeManager;
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('countDemande', [$this, 'countDemande']),
        ];
    }

    public function countDemande(User $user)
    {
        return $this->userManager->countDemande($user)[1];
    }
}