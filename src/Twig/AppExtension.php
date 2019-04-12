<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use App\Entity\User;
use App\Manager\UserManager;
use App\Utils\StatusTreatment;

class AppExtension extends AbstractExtension
{
    private $demandeManager;
    private $statusTreatment;
    public function __construct(UserManager $userManager, StatusTreatment $statusTreatment)
    {
        $this->userManager     = $userManager;
        $this->statusTreatment = $statusTreatment;
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('countDemande', [$this, 'countDemande']),
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
}