<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use App\Entity\User;
use App\Entity\Taxes;
use App\Entity\TypeDemande;
use App\Entity\Commande;
use App\Repository\TarifsPrestationsRepository;
use App\Manager\{UserManager, TaxesManager, FraisTreatmentManager, StatusManager};
use App\Utils\StatusTreatment;
use App\Manager\DocumentAFournirManager;

class AppExtension extends AbstractExtension
{
    private $demandeManager;
    private $prestation;
    private $statusTreatment;
    private $taxManager;
    private $fraisTreatmentManager;
    private $statusManager;
    private $documentAFournirManager;
    public function __construct(
        UserManager $userManager, 
        StatusTreatment $statusTreatment,
        TarifsPrestationsRepository $prestation,
        TaxesManager $taxManager, 
        FraisTreatmentManager $fraisTreatmentManager,
        StatusManager $statusManager,
        DocumentAFournirManager $documentAFournirManager
    )
    {
        $this->userManager     = $userManager;
        $this->statusTreatment = $statusTreatment;
        $this->prestation = $prestation;
        $this->taxManager = $taxManager;
        $this->fraisTreatmentManager = $fraisTreatmentManager;
        $this->statusManager = $statusManager;
        $this->documentAFournirManager = $documentAFournirManager;
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('countDemande', [$this, 'countDemande']),
            new TwigFunction('checkDemande', [$this, 'checkDemande']),
            new TwigFunction('countCommandeUnchecked', [$this, 'countCommandeUnchecked']),
            new TwigFunction('fraisTraitement', [$this, 'fraisTraitement']),
            new TwigFunction('fraisTotalTraitement', [$this, 'fraisTotalTraitement']),
            new TwigFunction('tvaTraitement', [$this, 'tvaTraitement']),
            new TwigFunction('fraisTotal', [$this, 'fraisTotal']),
            new TwigFunction('fraisTotalHT', [$this, 'fraisTotalHT']),
            new TwigFunction('total', [$this, 'total']),
            new TwigFunction('fraisTraitementWhithTva', [$this, 'fraisTraitementWhithTva']),
            new TwigFunction('statusOfCommande', [$this, 'statusOfCommande']),
            new TwigFunction('checkFile', [$this, 'checkFile']),
            new TwigFunction('tvaCommande', [$this, 'tvaCommande']),
            new TwigFunction('fraisdossierWithoutTva', [$this, 'fraisdossierWithoutTva']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('amount', [$this, 'formatAmount']),
            new TwigFilter('cardNumber', [$this, 'formatCard']),
            new TwigFilter('statusMessage', [$this, 'statusMessage']),
            new TwigFilter('displayValue', [$this, 'displayValue']),
            new TwigFilter('displayEnergy', [$this, 'displayEnergy']),
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

    public function displayValue($value, $default = null)
    {
        return $value !== null ? $value : ($default? $default : "--");
    }

    public function displayEnergy($value, $default = null)
    {
        $value = $this->displayValue($value, $default);
        if (isset(Taxes::ENERGY_VALUES[$value])) {
            return Taxes::ENERGY_VALUES[$value];
        }

        return $default? $default : "--";
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

    public function checkDemande(User $user)
    {
        return $this->userManager->checkDemande($user)[1];
    }

    public function countCommandeUnchecked(User $user)
    {
        return $this->userManager->countCommandeUnchecked($user)[1];
    }

    private function fraisTraitement(Commande $commande)
    {
        return $this->fraisTreatmentManager->fraisTreatmentOfCommande($commande);
    }

    public function tvaFraisTotalTraitement(Commande $commande)
    {

        return $this->fraisTreatmentManager->fraisTotalTreatmentOfCommande($commande) * 0.2 ;
    }

    public function fraisTotalTraitement(Commande $commande)
    {

        return $this->fraisTreatmentManager->fraisTotalTreatmentOfCommande($commande);
    }

    public function fraisTraitementWhithTva(Commande $commande)
    {

        return $this->fraisTreatmentManager->fraisTotalTreatmentOfCommandeWithTva($commande);
    }
    public function fraisTotal(Commande $commande)
    {

        return $this->fraisTreatmentManager->fraisTotalOfCommande($commande);
    }
    public function fraisTotalHT(Commande $commande)
    {

        return $this->fraisTreatmentManager->fraisTotalHtOfCommande($commande);
    }

    public function tvaTraitement(Commande $commande)
    {

        return $this->fraisTreatmentManager->tvaOfFraisTreatment($commande);
    }

    public function statusOfCommande(Commande $commande, string $need)
    {

        return $this->statusManager->getStatusOfCommande($commande)[$need];
    }

    public function total(Commande $commande)
    {

        return $this->fraisTreatmentManager->total($commande);
    }

    public function checkFile($entity, $name)
    {
        return $this->documentAFournirManager->checkFile($entity, $name);
    }

    public function tvaCommande(Commande $commande)
    {
        return $this->fraisTreatmentManager->tvaTreatmentOfCommande($commande) . ' %';
    }

    public function fraisdossierWithoutTva(Commande $commande)
    {
        return $this->fraisTreatmentManager->fraisTreatmentWithoutTaxesOfCommande($commande);
    }
}
