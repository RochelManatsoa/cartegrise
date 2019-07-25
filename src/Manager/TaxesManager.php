<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 12:27:51
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-25 13:27:43
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

	public function createFromTmsResponse(Response $tmsResponse, Commande $commande, Response $tmsInfoImmat, $type = "ECGAUTO"): Taxes
	{
        $value = $tmsResponse->getRawData();
        $typeDemarche = $commande->getDemarche()->getType();
        if(isset($value->Erreur)){
            throw new \Exception($value->Erreur);
        }
        $taxe = new Taxes();
        // $puissanceFisc = $type === "ECG" ? $value->Lot->Demarche->{$type}->Vehicule->Puissance :null;
        $puissanceFisc = $type === "ECG" ? $value->Lot->Demarche->ECG->TypeECG->{$commande->getDemarche()->getType()}->Vehicule->Puissance :null;
        if (isset($value->Lot->Demarche->ECG))
            $type = "ECG";
        $response = $value->Lot->Demarche->{$type}->Reponse;
        $tmsResponse = $tmsInfoImmat->getRawData()->InfoVehicule->Reponse;
        // manage taxe with configuration
        $this->taxLogicalManager->getRealTaxes($taxe, $commande, $response, $puissanceFisc);
        if ($type === "ECG")
        {
            if ($typeDemarche === "DIVN")
                $this->carInfoManager->generateCarInfoForDivn($commande);
        }
        $otherINfo = $type === "ECG" ? ($typeDemarche === "DIVN" ? $value->Lot->Demarche->{$type}->Vehicule: $tmsResponse->Positive) : $tmsResponse->Positive;
        // dd($otherINfo);
        $vin = $type === "ECG" ? null : $tmsResponse->Positive->VIN;
        $dateMec = ($type === "ECG" && $typeDemarche === "DIVN") ? \DateTime::createFromFormat('d/m/Y', $otherINfo->DateMec) : \DateTime::createFromFormat('Y-m-d', $otherINfo->DateMec);
        $taxe->setVIN($vin)
            ->setCO2($otherINfo->CO2)
            ->setPuissance($otherINfo->PuissFisc)
            ->setGenre($this->getGenreResponseTms($otherINfo->Genre))
            // ->setPTAC($otherINfo->PTAC)
            ->setEnergie($otherINfo->Energie)
            ->setDateMEC($dateMec)
        ;

        return $taxe;
    }

    public function getGenreResponseTms(string $index){
        $gender = [
            "VP" => 1, "CTTE" => 2, "Deriv-VP" => 2, "CAM" => 3, "TCP" => 3, "TRR" => 3, "VASP" => 4, "MTL" => 5, "MTT1" => 5, "MTT2" => 5, "CL" => 6, "QM" => 7, "TRA" => 8, "REM" => 9, "SREM" => 9, "RESP" => 9, "TM" => 10, "CYCL" => 11
        ];
        
        return $gender[$index];
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