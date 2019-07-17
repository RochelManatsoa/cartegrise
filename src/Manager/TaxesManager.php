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
use App\Manager\TaxeUtils\TaxeLogicalManager;
use App\Manager\CarInfoManager;

class TaxesManager
{
    private $taxLogicalManager;
    private $carInfoManager;

    public function __construct(
        TaxeLogicalManager $taxLogicalManager,
        CarInfoManager $carInfoManager
    )
    {
        $this->taxLogicalManager = $taxLogicalManager;
        $this->carInfoManager = $carInfoManager;
    }

	public function createTax()
	{
		$taxes = new Taxes();

		return $taxes;
    }

	public function createFromTmsResponse(Response $tmsResponse, Commande $commande, $type = "ECGAUTO"): Taxes
	{
        $value = $tmsResponse->getRawData();
        if(isset($value->Erreur)){
            throw new \Exception($value->Erreur);
        }
        $taxe = new Taxes();
        $puissanceFisc = $type === "ECG" ? $value->Lot->Demarche->{$type}->Vehicule->Puissance :null;
        $response = $value->Lot->Demarche->{$type}->Reponse;
        // manage taxe with configuration
        $this->taxLogicalManager->getRealTaxes($taxe, $commande, $response, $puissanceFisc);
        if ($type === "ECG")
        {
            $this->carInfoManager->generateCarInfoForDivn($tmsResponse, $commande);
        }
        $otherINfo = $type === "ECG" ? $value->Lot->Demarche->{$type}->Vehicule : $response->Positive;
        $vin = $type === "ECG" ? null : $response->Positive->VIN;
        $dateMec = $type === "ECG" ? \DateTime::createFromFormat('d/m/Y', $otherINfo->DateMEC) : \DateTime::createFromFormat('Y-m-d', $otherINfo->DateMEC);
        $taxe->setVIN($vin)
            ->setCO2($otherINfo->CO2)
            ->setPuissance($otherINfo->Puissance)
            ->setGenre($otherINfo->Genre)
            ->setPTAC($otherINfo->PTAC)
            ->setEnergie($otherINfo->Energie)
            ->setDateMEC($dateMec)
        ;

        return $taxe;
    }
    
    public function getMajoration(Taxes $taxe)
    {
        $service = $taxe->getTaxeTotale();
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