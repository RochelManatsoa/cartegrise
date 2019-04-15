<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use App\Entity\User;
use App\Entity\TypeDemande;
use App\Repository\TarifsPrestationsRepository;
use App\Manager\UserManager;
use App\Utils\StatusTreatment;

class AppExtension extends AbstractExtension
{
    private $demandeManager;
    private $prestation;
    private $statusTreatment;
    public function __construct(UserManager $userManager, StatusTreatment $statusTreatment, TarifsPrestationsRepository $prestation)
    {
        $this->userManager     = $userManager;
        $this->statusTreatment = $statusTreatment;
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

    public function getFilters()
    {
        return [
            new TwigFilter('amount', [$this, 'formatAmount']),
            new TwigFilter('cardNumber', [$this, 'formatCard']),
            new TwigFilter('statusMessage', [$this, 'statusMessage']),
        ];
    }

    // function 

    public function formatAmount($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $number = $number / 100;
        
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price. ' €';

        return $price;
    }

    public function formatCard($number, $date)
    {
        
        if (strlen($number) < 1)
            return '';
        $number = explode('.', $number);
        $date = $this->getNStartAtEnd($date, 2);
        $number = $number[0] . ' #### #### ## ' . $number[1] . ' ' . $date;
        
        return $number;
    }

    public function statusMessage($code)
    {
        return $this->statusTreatment->getMessageStatus($code);
    }

    public function getNStartAtEnd($val, $n = 1)
    {
        $return = str_split($val, $n);
        if(isset($val[1]) && isset($val[2]))
            return $return[1]. '/' . $return[2];
        return '';
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

    public function fraisTotalTraitement(float $prestation, float $majoration)
    {
        return $prestation + $majoration;
    }

    public function fraisTotal(float $taxe, float $prestation, float $majoration)
    {
        return $taxe + $prestation + $majoration;
    }
}