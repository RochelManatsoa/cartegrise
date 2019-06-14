<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 12:27:51
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-12 16:28:55
 */

namespace App\Manager\TaxeUtils;

use App\Entity\{Taxes, Configuration, Commande};
use App\Services\Tms\Response;
use App\Manager\ConfigurationManager;

class TaxeLogicalManager
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

        
    private function getConfiguration($value) : ?Configuration
    {
        return $this->configurationManager->find($value);
    }

    public function witoutTaxesTreatment(Configuration $withoutTaxes, $type)
    {
        if ($withoutTaxes instanceof Configuration){
            $WithoutTAxesConfig = $withoutTaxes->{'get'.$type}();
            if ($WithoutTAxesConfig) {
                return true;
            }      
        }

        return false;
    }

    public function getRealTaxes(Taxes $taxe, Commande $commande, $value)
    {
        // get type of comande
        $type = $commande->getDemarche()->getType();
        // to know if the the configuration have taxe or not
        $withoutTaxes = $this->getConfiguration(Configuration::TAXE_REGIONAL_WITHOUT_TAXES);
        //to check if command is with taxes regional or not
        $withoutTaxesTreatment = $this->witoutTaxesTreatment($withoutTaxes, $type);
        if ($withoutTaxesTreatment){
            return;     
        }

        // to know if the the configuration have taxeRegional
        $withoutTaxesRegional = $this->getConfiguration(Configuration::TAXE_REGIONAL);
        // to know if the configuration have able or not to multiply with fiscal power
        $taxeRegionalWithoutMultiplePuissFisc = $this->getConfiguration(Configuration::TAXE_REGIONAL_WITHOUT_MULTIPLE_POWERFISC);
        // define default value
        $withTaxeRegional = true;
        $withoutPuissanceMultipleFisc=true;

        //to check if command is with taxes regional or not
        if ($withoutTaxesRegional instanceof Configuration){
            $configTaxesRegional = $withoutTaxesRegional->{'get'.$type}();
            if ($configTaxesRegional) {
                $withTaxeRegional = false;
            }      
        }
        //to check if command is with taxes regional or not
        if ($taxeRegionalWithoutMultiplePuissFisc instanceof Configuration){
            $taxeRegionalWithoutMultiplePuissFiscConfig = $taxeRegionalWithoutMultiplePuissFisc->{'get'.$type}();
            if ($taxeRegionalWithoutMultiplePuissFiscConfig) {
                $withoutPuissanceMultipleFisc = false;
            }      
        }
        //to apply if haven't taxes regional
        if ($withTaxeRegional) {
            $taxeTotal = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale;
            $taxeRegionalInit = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale;
            $taxeRegional = $value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale;
            if (!$withoutPuissanceMultipleFisc) {
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

        $taxe->setTaxeParafiscale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeParafiscale)
            ->setTaxeCO2($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeCO2)
            ->setTaxeMalus($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeMalus)
            ->setTaxeSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeSIV)
            ->setTaxeRedevanceSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRedevanceSIV);
    }

}