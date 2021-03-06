<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 12:27:51
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-26 15:25:43
 */

namespace App\Manager;

use App\Entity\CarInfo;
use App\Entity\Commande;
use App\Services\Tms\Response;

class CarInfoManager
{
	public function createCarInfo(): CarInfo
	{
		$carInfo = new CarInfo();

		return $carInfo;
	}

	public function createInfoFromTmsImmatResponse(Response $tmsInfoImmat): CarInfo
	{
        $value = $this->getResponseConvert($tmsInfoImmat);
        $carInfo = $this->createCarInfo();
        $carInfo
            ->setMarque($value->Marque)
            ->setModel($value->Modele)
            ->setSerialNumber($value->NSerie)
            ->setColor($value->Couleur)
            ->setNbPlace($value->NbPlacesAss)
            ->setHorsePower($value->PuissCh)
            ->setHorsePowerFiscal($value->PuissFisc)
            ->setVersion($value->Version)
            ->setVin($value->VIN)
            ->setData(json_encode($value))
            ;

        return $carInfo;
    }

    public function generateCarInfoForDivn(Commande $commande)
    {
        $carInfo = $this->createCarInfo();
        $carInfo
            ->setMarque($commande->getDivnInit()->getMarque())
            ->setHorsePowerFiscal($commande->getDivnInit()->getPuissanceFiscale())
            ;
        $commande->setCarInfo($carInfo);

    }
    
    public function getResponseConvert(Response $tmsInfoImmat)
    {
        $value = $tmsInfoImmat->getRawData();

        return $value->InfoVehicule->Reponse->Positive;
    }
}