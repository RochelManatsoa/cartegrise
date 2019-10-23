<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 12:27:51
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-26 15:42:10
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

	public function createFromTmsResponse(Response $tmsResponse, Commande $commande, $tmsInfoImmat, $type = "ECGAUTO"): Taxes
	{
        $value = $tmsResponse->getRawData();
        $typeDemarche = $commande->getDemarche()->getType();
        if(isset($value->Erreur)){
            throw new \Exception($value->Erreur);
        }
        $taxe = new Taxes();
        // $puissanceFisc = $type === "ECG" ? $value->Lot->Demarche->{$type}->Vehicule->Puissance :null;
        $puissanceFisc = null;
        if (isset($value->Lot->Demarche->ECG))
            $type = "ECG";
        $response = $value->Lot->Demarche->{$type}->Reponse;
        if (is_object($tmsInfoImmat))
            $tmsResponse = $tmsInfoImmat->getRawData()->InfoVehicule->Reponse;
        // manage taxe with configuration
        if ($type === "ECG")
        {
            if ($typeDemarche === "DIVN") {
                $this->carInfoManager->generateCarInfoForDivn($commande);
                $puissanceFisc = $value->Lot->Demarche->{$type}->TypeECG->VN->Vehicule->Puissance;
                $otherINfo = $value->Lot->Demarche->{$type}->TypeECG->VN->Vehicule;
            } elseif ($typeDemarche === "DUP") {
                $puissanceFisc = $value->Lot->Demarche->ECG->TypeECG->{$commande->getDemarche()->getType()}->Vehicule->Puissance;
                $otherINfo = $tmsResponse->Positive;
            } else {
                $otherINfo = $tmsResponse->Positive;
            }
        } else {
            $otherINfo = $tmsResponse->Positive;
        }
        $this->taxLogicalManager->getRealTaxes($taxe, $commande, $response, $puissanceFisc);
        $this->moreInfoTaxes($taxe, $otherINfo, $tmsResponse, $typeDemarche);

        return $taxe;
    }

    public function moreInfoTaxes(Taxes $taxe, $otherINfo, $tmsResponse, $typeDemarche)
    {
        if ($typeDemarche === "DIVN") {
            $dateMec = \DateTime::createFromFormat('d/m/Y', $otherINfo->DateMEC);
            $puissanceFisc = $otherINfo->Puissance;
            $vin = null;
        } elseif($typeDemarche === "DUP") {
            $dateMec = \DateTime::createFromFormat('Y-m-d', $otherINfo->DateMec);
            $puissanceFisc = $otherINfo->PuissFisc;
            $vin = $otherINfo->VIN;
        } elseif ($typeDemarche === "CTVO") {
            $dateMec = \DateTime::createFromFormat('Y-m-d', $otherINfo->DateMec);
            $puissanceFisc = $otherINfo->PuissFisc;
            $vin = $tmsResponse->Positive->VIN;
        } elseif ($typeDemarche === "DCA") {
            $dateMec = \DateTime::createFromFormat('Y-m-d', $otherINfo->DateMec);
            $puissanceFisc = $otherINfo->PuissFisc;
            $vin = $tmsResponse->Positive->VIN;
        } elseif ($typeDemarche === "DC") {
            $dateMec = \DateTime::createFromFormat('Y-m-d', $otherINfo->DateMec);
            $puissanceFisc = $otherINfo->PuissFisc;
            $vin = $tmsResponse->Positive->VIN;
        } else {
            $dateMec = \DateTime::createFromFormat('d/m/Y', $otherINfo->DateMec);
            $puissanceFisc = $otherINfo->PuissFisc;
            $vin = $tmsResponse->Positive->VIN;
        }

        $taxe->setVIN($vin)
            ->setCO2($otherINfo->CO2)
            ->setPuissance($puissanceFisc)
            ->setGenre(is_numeric($otherINfo->Genre)? $otherINfo->Genre : $this->getGenreResponseTms($otherINfo->Genre))
            ->setPTAC(isset($otherINfo->PTAC)?$otherINfo->PTAC:null)
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