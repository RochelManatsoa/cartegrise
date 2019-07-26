<?php

/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-17 13:14:01 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-25 18:39:27
 */
namespace App\Manager;

use App\Entity\DivnInit;
use App\Manager\{CommandeManager, TaxesManager};
use App\Repository\TypeDemandeRepository;

class DivnInitManager
{
    private $commandeManager;
    private $typeDemandeRepository;
    private $taxesManager;
    public function __construct(
        CommandeManager $commandeManager,
        TypeDemandeRepository $typeDemandeRepository,
        TaxesManager $taxesManager
    )
    {
        $this->commandeManager = $commandeManager;
        $this->typeDemandeRepository = $typeDemandeRepository;
        $this->taxesManager = $taxesManager;
    }
    public function manageSubmit(DivnInit $divnInit)
    {
        $this->initCommande($divnInit);
        $commande = $divnInit->getCommande();
        $responseTaxes = $this->commandeManager->tmsDivnEnvoyer($commande);
        $this->taxesManager->createFromTmsResponse($responseTaxes, $commande, null, "ECG");
        $this->commandeManager->save($commande);
    }

    private function initCommande(DivnInit $divnInit)
    {
        $demarche = $this->typeDemandeRepository->findOneBy(['type'=>"DIVN"]);
        $commande = $this->commandeManager->createCommande();
        $commande->setDivnInit($divnInit);
        $commande->setCodePostal($divnInit->getDepartment());
        $commande->setDemarche($demarche);
    }
    
}
