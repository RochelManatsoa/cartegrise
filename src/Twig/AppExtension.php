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
            new TwigFunction('tvaTraitementDailyTotal', [$this, 'tvaTraitementDailyTotal']),
            new TwigFunction('fraisTotal', [$this, 'fraisTotal']),
            new TwigFunction('fraisTotalHT', [$this, 'fraisTotalHT']),
            new TwigFunction('total', [$this, 'total']),
            new TwigFunction('fraisTraitementWhithTva', [$this, 'fraisTraitementWhithTva']),
            new TwigFunction('fraisTraitementWhithTvaTotal', [$this, 'fraisTraitementWhithTvaTotal']),
            new TwigFunction('statusOfCommande', [$this, 'statusOfCommande']),
            new TwigFunction('checkFile', [$this, 'checkFile']),
            new TwigFunction('tvaCommande', [$this, 'tvaCommande']),
            new TwigFunction('without20tva', [$this, 'without20tva']),
            new TwigFunction('finalTotalOfDaily', [$this, 'finalTotalOfDaily']),
            new TwigFunction('without20tvaTotal', [$this, 'without20tvaTotal']),
            new TwigFunction('getTaxesTotal', [$this, 'getTaxesTotal']),
            new TwigFunction('totalOfDemandesDaily', [$this, 'totalOfDemandesDaily']),
            new TwigFunction('just20tvaTotal', [$this, 'just20tvaTotal']),
            new TwigFunction('tvaTreatmentOfCommandeTotal', [$this, 'tvaTreatmentOfCommandeTotal']),
            new TwigFunction('fraisdossierWithoutTva', [$this, 'fraisdossierWithoutTva']),
            new TwigFunction('fraisdossierWithoutTvaDailyFacture', [$this, 'fraisdossierWithoutTvaDailyFacture']),
            new TwigFunction('fraisdossierWithoutTvaTotal', [$this, 'fraisdossierWithoutTvaTotal']),
            new TwigFunction('getTarifPresentation', [$this, 'getTarifPresentation']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('amount', [$this, 'formatAmount']),
            new TwigFilter('cardNumber', [$this, 'formatCard']),
            new TwigFilter('statusMessage', [$this, 'statusMessage']),
            new TwigFilter('displayValue', [$this, 'displayValue']),
            new TwigFilter('displayGender', [$this, 'displayGender']),
            new TwigFilter('displayRelanceInfos', [$this, 'displayRelanceInfos']),
            new TwigFilter('displayEnergy', [$this, 'displayEnergy']),
            new TwigFilter('formatFacture', [$this, 'formatFacture']),
        ];
    }

    // function 

    public function formatFacture($value)
    {
        $case = strlen($value);
        switch($case){
            case "1": 
                $return = '000'.$value;
            break;
            case "2": 
                $return = '00'.$value;
            break;
            case "3": 
                $return = '0'.$value;
            break;
            default: 
                $return = $value;
            break;
        }

        return $return;
    }

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
    public function displayGender($value, $default = null)
    {
        return $value === "M" ? "Mr" : 'Mme';
    }
    public function displayRelanceInfos($value, $default = null)
    {
        if (is_object($value))
            return $this->displayGender($value->getClientGenre()).' '.$this->displayValue($value->getClientNom()).' '.$this->displayValue($value->getClientPrenom());

        return $this->displayGender($value['clientGenre']).' '.$this->displayValue($value['clientNom']).' '.$this->displayValue($value['clientPrenom']);
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
    public function fraisTraitementWhithTvaTotal(array $demandes)
    {
        $result = 0;
        foreach ($demandes as $demande) {
            $result += $this->fraisTreatmentManager->fraisTotalTreatmentOfCommandeWithTvaDaily($demande->getCommande());
        }

        return $result;
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
    public function tvaTraitementDailyTotal(array $demandes)
    {
        $result = 0;
        foreach ($demandes as $demande){
            $result += $this->fraisTreatmentManager->tvaOfFraisTreatmentDaily($demande->getCommande());
        }

        return $result;
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
    public function fraisdossierWithoutTvaDailyFacture(Commande $commande)
    {
        return $this->fraisTreatmentManager->fraisTreatmentWithoutTaxesOfCommandeDaily($commande);
    }

    public function fraisdossierWithoutTvaTotal(array $demandes)
    {
        return $this->fraisTreatmentManager->fraisTreatmentWithoutTaxesOfCommandeDaily($demandes[0]->getCommande()) * count($demandes);
    }

    public function tvaTreatmentOfCommandeTotal(array $demandes)
    {
        return $this->fraisTreatmentManager->tvaTreatmentOfCommande($demandes[0]->getCommande()) * count($demandes);
    }

    public function getTarifPresentation(Commande $commande)
    {
        return $this->fraisTreatmentManager->fraisTreatmentWithoutTaxesOfCommande($commande);
    }
    public function without20tva(int $value)
    {
        if (is_null($value) || $value == 0)
        {
            return 0;
        }
        return round(($value/1.2), 2);
    }
    public function without20tvaTotal(int $value, int $length)
    {
        if (is_null($value) || $value == 0)
        {
            return 0;
        }
        return round(($value/1.2), 2) * $length;
    }
    public function just20tvaTotal(int $value, int $length)
    {
        if (is_null($value) || $value == 0)
        {
            return 0;
        }
        return round((round(($value/1.2), 2) * 0.2 * $length), 2);
    }
    public function totalOfDemandesDaily(array $demandes, array $majorations)
    {
        $majorationResult = 0;
        $results = 0;
        foreach($majorations as $key=>$majoration)
        {
            $majorationResult += $key;
        }
        $results = $this->fraisTraitementWhithTvaTotal($demandes);

        return $majorationResult+$results;
    }
    public function finalTotalOfDaily(array $demandes, array $majorations)
    {
        $fraistreatment = $this->totalOfDemandesDaily($demandes, $majorations);
        $totalTaxes = $this->getTaxesTotal($demandes);

        return round(($fraistreatment + $totalTaxes), 2);
    }
    public function getTaxesTotal(array $demandes)
    {
        $taxesTotal = 0;
        foreach($demandes as $key=>$demande)
        {
            $taxesTotal += $demande->getCommande()->getTaxes()->getTaxeTotale();
        }

        return $taxesTotal;
    }
}
