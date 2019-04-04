<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Entity\User;
use App\Entity\TypeDemande;
use App\Repository\TarifsPrestationsRepository;
use App\Manager\UserManager;

class AppExtension extends AbstractExtension
{
    private $demandeManager;
    public function __construct(UserManager $userManager, TarifsPrestationsRepository $prestation)
    {
        $this->userManager = $userManager;
        $this->prestation = $prestation;
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('countDemande', [$this, 'countDemande']),
            new TwigFunction('fraisTraitement', [$this, 'fraisTraitement']),
            new TwigFunction('fraisTotalTraitement', [$this, 'fraisTotalTraitement']),
            new TwigFunction('fraisTotal', [$this, 'fraisTotal']),
        ];
    }

    public function countDemande(User $user)
    {
        return $this->userManager->countDemande($user)[1];
    }

    public function fraisTraitement(TypeDemande $commande)
    {
        $price = $this->prestation->find($commande);
        if($price == null){
            return 0;
        }
        return $price->getPrix();
    }

    public function fraisTotalTraitement(int $prestation, int $majoration)
    {
        return $prestation + $majoration;
    }

    public function fraisTotal(int $taxe, int $prestation, int $majoration)
    {
        return $taxe + $prestation + $majoration;
    }
}