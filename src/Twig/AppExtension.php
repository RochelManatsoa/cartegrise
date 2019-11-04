<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
<<<<<<< HEAD
use App\Entity\User;
use App\Entity\Taxes;
use App\Entity\TypeDemande;
use App\Entity\Commande;
use App\Entity\EmailHistory;
=======
use App\Entity\{User, Taxes, TypeDemande, Commande, Adresse};
>>>>>>> f0fc114a541f18e2d81f2ff5a6c8db42cd1c8199
use App\Repository\TarifsPrestationsRepository;
use App\Manager\{UserManager, TaxesManager, FraisTreatmentManager, StatusManager};
use App\Utils\StatusTreatment;
use App\Manager\DocumentAFournirManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Validator\Constraints\File;

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
            new TwigFunction('taxeTotal', [$this, 'taxeTotal']),
            new TwigFunction('tvaCommande', [$this, 'tvaCommande']),
            new TwigFunction('without20tva', [$this, 'without20tva']),
            new TwigFunction('finalTotalOfDaily', [$this, 'finalTotalOfDaily']),
            new TwigFunction('without20tvaTotal', [$this, 'without20tvaTotal']),
            new TwigFunction('getTaxesTotal', [$this, 'getTaxesTotal']),
            new TwigFunction('totalOfDemandesDaily', [$this, 'totalOfDemandesDaily']),
            new TwigFunction('totalOfDemandesDailyWithoutTvaAndMajoration', [$this, 'totalOfDemandesDailyWithoutTvaAndMajoration']),
            new TwigFunction('totalOfTvaDailyWithoutMajoration', [$this, 'totalOfTvaDailyWithoutMajoration']),
            new TwigFunction('totalOfDemandesDailyWithoutMajoration', [$this, 'totalOfDemandesDailyWithoutMajoration']),
            new TwigFunction('totalOfMajorationDaily', [$this, 'totalOfMajorationDaily']),
            new TwigFunction('totalTvaOfMajorationDaily', [$this, 'totalTvaOfMajorationDaily']),
            new TwigFunction('totalWithoutTvaOfMajorationDaily', [$this, 'totalWithoutTvaOfMajorationDaily']),
            new TwigFunction('just20tvaTotal', [$this, 'just20tvaTotal']),
            new TwigFunction('tvaTreatmentOfCommandeTotal', [$this, 'tvaTreatmentOfCommandeTotal']),
            new TwigFunction('fraisdossierWithoutTva', [$this, 'fraisdossierWithoutTva']),
            new TwigFunction('fraisdossierWithoutTvaDailyFacture', [$this, 'fraisdossierWithoutTvaDailyFacture']),
            new TwigFunction('fraisdossierWithoutTvaTotal', [$this, 'fraisdossierWithoutTvaTotal']),
            new TwigFunction('getTarifPresentation', [$this, 'getTarifPresentation']),
            new TwigFunction('totalPrestationMajorationWithoutTaxeDaily', [$this, 'totalPrestationMajorationWithoutTaxeDaily']),
            new TwigFunction('totalPrestationMajorationTaxeDaily', [$this, 'totalPrestationMajorationTaxeDaily']),
            new TwigFunction('totalPrestationMajorationTTC', [$this, 'totalPrestationMajorationTTC']),
            new TwigFunction('displayAccepted', [$this, 'displayAccepted']),
            new TwigFunction('decodeBody', [$this, 'decodeBody']),
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
            new TwigFilter('displayAdress', [$this, 'displayAdress']),
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
        } elseif (!is_null($value) && $value != "") {
            return $value;
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
    public function fraisDailyWithoutTvaTotal(array $demandes)
    {
        $result = 0;
        foreach ($demandes as $demande) {
            $result += $this->fraisTreatmentManager->fraisTreatmentWithoutTaxesOfCommandeDaily($demande->getCommande());
        }

        return $result;
    }
    public function fraisDailyTvaTotal(array $demandes)
    {
        $result = 0;
        foreach ($demandes as $demande) {
            $result += $this->fraisTreatmentManager->tvaOfFraisTreatmentDaily($demande->getCommande());
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
        return $value/1.2;
    }
    public function without20tvaTotal(int $value, int $length)
    {
        if (is_null($value) || $value == 0)
        {
            return 0;
        }
        return $value/1.2 * $length;
    }
    public function just20tvaTotal(int $value, int $length)
    {
        if (is_null($value) || $value == 0)
        {
            return 0;
        }
        return $value*(0.2/1.2) * $length;
    }
    public function totalOfDemandesDaily(array $demandes, array $majorations)
    {
        $majorationResult = 0;
        $results = 0;
        foreach($majorations as $key=>$majoration)
        {
            $majorationResult += $key*count($majoration);
        }
        $results = $this->fraisTraitementWhithTvaTotal($demandes);

        return $majorationResult+$results;
    }
    public function totalOfDemandesDailyWithoutMajoration(array $demandes)
    {
        $results = 0;
        $results = $this->fraisTraitementWhithTvaTotal($demandes);

        return $results;
    }
    public function totalOfTvaDailyWithoutMajoration(array $demandes)
    {
        $results = 0;
        $results = $this->fraisDailyTvaTotal($demandes);

        return $results;
    }
    public function totalOfDemandesDailyWithoutTvaAndMajoration(array $demandes)
    {
        $results = 0;
        $results = $this->fraisDailyWithoutTvaTotal($demandes);

        return $results;
    }
    public function totalOfMajorationDaily(array $majorations)
    {
        $majorationResult = 0;
        foreach($majorations as $key=>$majoration)
        {
            $majorationResult += $key*count($majoration);
        }
        return $majorationResult;
    }
    public function totalTvaOfMajorationDaily(array $majorations)
    {
        $majorationResult = $this->totalOfMajorationDaily($majorations)*(0.2/1.2);
        
        return $majorationResult;
    }
    public function totalWithoutTvaOfMajorationDaily(array $majorations)
    {
        $majoration = $this->totalOfMajorationDaily($majorations);
        $majorationTva = $this->totalTvaOfMajorationDaily($majorations);
        
        return $majoration - $majorationTva;
    }
    public function finalTotalOfDaily(array $demandes, array $majorations)
    {
        $fraistreatment = $this->totalOfDemandesDaily($demandes, $majorations);
        $totalTaxes = $this->getTaxesTotal($demandes);

        return $fraistreatment + $totalTaxes;
    }
    public function totalPrestationMajorationWithoutTaxeDaily(array $demandes, array $majorations)
    {
        $fraistreatment = $this->totalWithoutTvaOfMajorationDaily($majorations);
        $totalTaxes = $this->totalOfDemandesDailyWithoutTvaAndMajoration($demandes);

        return $fraistreatment + $totalTaxes;
    }
    public function totalPrestationMajorationTaxeDaily(array $demandes, array $majorations)
    {
        $majorationTva = $this->totalTvaOfMajorationDaily($majorations);
        $totalTaxes = $this->totalOfTvaDailyWithoutMajoration($demandes);

        return $majorationTva + $totalTaxes;
    }
    public function totalPrestationMajorationTTC(array $demandes, array $majorations)
    {
        $fraistreatment = $this->totalOfMajorationDaily($majorations);
        $totalTaxes = $this->totalOfDemandesDailyWithoutMajoration($demandes);

        return $fraistreatment + $totalTaxes;
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
    public function displayAccepted(object $object, string $argument): string
    {
        $annotations = $this->getProperty($object, $argument);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof File) {
                $annotationFile = $annotation;
            }
        }
        
        if (isset($annotationFile->mimeTypes) && is_array($annotationFile->mimeTypes)) {
            $typeFile = ', ( ';
            foreach ($annotationFile->mimeTypes as $key => $value) {
                $typeFile .=  ($value == end($annotationFile->mimeTypes)) ? $this->getTypeOfMimeType($value).' ' : $this->getTypeOfMimeType($value) . ', ' ; 
            }

            if (isset($annotationFile->maxSize)) {
                $typeFile.=', maxSize: '. $this->convertToReadableSize($annotationFile->maxSize) . ')';
            } else {
                $typeFile.=')';
            }
        } else {
            return '';
        }

        return $typeFile;
    }

    private function getTypeOfMimeType($value){
        return str_replace('application/', '', $value);
    }

    private function convertToReadableSize($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);

        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
    /**
     * @param $class
     * @param $property
     * @return array
     */
    private function getProperty($class, $property)
    {
        $reader = new AnnotationReader;
        $reflector = new \ReflectionProperty($class, $property);

        return $reader->getPropertyAnnotations($reflector);
    }

    public function decodeBody(EmailHistory $emailHistory){
        $email = \base64_decode($emailHistory->getBody());

        return $email;
    }
    public function displayAdress($value, $default = null)
    {
        $value = $this->displayValue($value, $default);
        if (isset(Adresse::ROAD_NAME[$value])) {
            return Adresse::ROAD_NAME[$value];
        } elseif (!is_null($value) && $value != "") {
            return $value;
        }
        return $default? $default : "--";
    }

}
