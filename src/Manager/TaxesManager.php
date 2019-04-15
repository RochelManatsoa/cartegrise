<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 12:27:51
 * @Last Modified by:   stephan
 * @Last Modified time: 2019-04-15 12:37:11
 */

namespace App\Manager;

use App\Entity\Taxes;
use App\Services\Tms\Response;

class TaxesManager
{
	public function createTax()
	{
		$taxes = new Taxes();

		return $taxes;
	}

	public function createFromTmsResponse(Response $tmsResponse): Taxes
	{
		$value = $tmsResponse->getRawData();
        $taxe = new Taxes();

        $taxe->setTaxeRegionale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRegionale)
            ->setTaxe35cv($value->Lot->Demarche->ECGAUTO->Reponse->Positive->Taxe35cv)
            ->setTaxeParafiscale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeParafiscale)
            ->setTaxeCO2($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeCO2)
            ->setTaxeMalus($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeMalus)
            ->setTaxeSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeSIV)
            ->setTaxeRedevanceSIV($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeRedevanceSIV)
            ->setTaxeTotale($value->Lot->Demarche->ECGAUTO->Reponse->Positive->TaxeTotale)
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
}