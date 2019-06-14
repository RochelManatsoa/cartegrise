<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 12:27:51
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-12 16:28:55
 */

namespace App\Manager;

use App\Entity\{Taxes, Configuration, Commande};
use App\Services\Tms\Response;
use App\Manager\ConfigurationManager;

class TaxesManager
{
    /**
     * configurationManager
     *
     * @var ConfigurationManager
     */
    private $configurationManager;
    /**
     * Undocumented function
     *
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(
        ConfigurationManager $configurationManager
    )
    {
        $this->configurationManager = $configurationManager;
    }

	public function createTax()
	{
		$taxes = new Taxes();

		return $taxes;
    }
    
    private function getConfiguration($value) : ?Configuration
    {
        return $this->configurationManager->find($value);
    }

	public function createFromTmsResponse(Response $tmsResponse, Commande $commande): Taxes
	{
        $value = $tmsResponse->getRawData();
        if(isset($value->Erreur)){
            throw new \Exception($value->Erreur);
        }
        $taxe = new Taxes();
        // to know if the the configuration have taxeRegional
        $taxeRegional = $this->getConfiguration(Configuration::TAXE_REGIONAL);
        // to know if the configuration have able or not to multiply with fiscal power
        $taxeRegionalWithoutMultiplePuissFisc = $this->getConfiguration(Configuration::TAXE_REGIONAL_WITHOUT_MULTIPLE_POWERFISC);
        // define default value
        $withTaxeRegional = true;
        $withMultiplePuissanceFisc=true;
        // get type of comande
        $type = $commande->getDemarche()->getType();
        //to check if command is with taxes regional or not
        if ($taxeRegionalWithoutMultiplePuissFisc instanceof Configuration){
            $taxeRegionalWithoutMultiplePuissFiscConfig = explode(',', $taxeRegionalWithoutMultiplePuissFisc->getValueConf());
            if (in_array($type, $taxeRegionalWithoutMultiplePuissFiscConfig)) {
                $withMultiplePuissanceFisc = false;
            }      
        }
        //to check if command is with taxes regional or not
        if ($taxeRegional instanceof Configuration){
            $configTaxesRegional = explode(',', $taxeRegional->getValueConf());
            if (in_array($type, $configTaxesRegional)) {
                $withTaxeRegional = false;
            }      
        }
        //to apply if haven't taxes regional
        if ($withTaxeRegional) {
            $taxeTotal = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale;
            $taxeRegionalInit = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale;
            $taxeRegional = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale;
            if (!$withMultiplePuissanceFisc) {
                $taxeRegional = $taxeRegionalInit / $value->Lot->Demarche->ECGAUTO->Reponse->Positive->Puissance;
            }
            $taxeTotal = $taxeTotal - $taxeRegionalInit + $taxeRegional;

            $taxe
            ->setTaxeRegionale($taxeRegional)
            ->setTaxeTotale($taxeTotal);
        } else {
            $taxeRegional = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale;
            $taxeTotal = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale;
            $taxeTotal = $taxeTotal - $taxeRegional;
            $taxe->setTaxeTotale($taxeTotal);
        } 
        $taxe->setTaxe35cv($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Taxe35cv)
            ->setTaxeParafiscale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeParafiscale)
            ->setTaxeCO2($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeCO2)
            ->setTaxeMalus($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeMalus)
            ->setTaxeSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeSIV)
            ->setTaxeRedevanceSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRedevanceSIV)
            ->setVIN($value->Lot->Demarche->ECGAUTO->Reponse->Positive->VIN)
            ->setCO2($value->Lot->Demarche->ECGAUTO->Reponse->Positive->CO2)
            ->setPuissance($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Puissance)
            ->setGenre($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Genre)
            ->setPTAC($value->Lot->Demarche->ECGAUTO->Reponse->Positive->PTAC)
            ->setEnergie($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Energie)
            ->setDateMEC(\DateTime::createFromFormat('Y-m-d', $value->Lot->Demarche->ECGAUTO->Reponse->Positive->DateMEC))
        ;

        return $taxe;
    }
    
    public function getMajoration(Taxes $taxe)
    {
        $service = $taxe->getTaxeRegionale();
        if ($service <= 100) {
            $majoration = 0;
        }elseif ($service > 101 && $service < 300) {
            $majoration = 7;
        }elseif ($service > 301 && $service < 400) {
            $majoration = 11;
        }elseif ($service > 401 && $service < 600) {
            $majoration = 17;
        }elseif ($service > 601 && $service < 800) {
            $majoration = 21;
        }elseif ($service > 801 && $service < 1000) {
            $majoration = 27;
        }elseif ($service > 1001 && $service < 1499) {
            $majoration = 31;
        }elseif ($service > 1500) {
            $majoration = 41;
        }

        return $majoration;
    }
}