<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Facture;
use App\Repository\InfosFactureRepository;
use Twig_Environment as Twig;
use App\Utils\StatusTreatment;

class InfosFactureManager
{
    private $em;
    private $repository;
    private $statusTreatment;
    private $transactionRepository;
    private $transactionManager;
    public function __construct
    (
        EntityManagerInterface            $em,
        InfosFactureRepository            $repository
    )
    {
        $this->em                       =  $em;
        $this->repository               =  $repository;
    }

    public function init()
    {
        return new Facture();
    }

    public function save(InfosFacture $infosFacture)
    {
        if (!$infosFacture instanceof InfosFacture)
            return;
        $this->em->persist($infosFacture);
        $this->em->flush();
    }

}