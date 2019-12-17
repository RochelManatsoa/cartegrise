<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Facture;
use App\Repository\FactureRepository;
use Twig_Environment as Twig;
use App\Utils\StatusTreatment;

class FactureManager
{
    private $em;
    private $repository;
    private $statusTreatment;
    private $transactionRepository;
    private $transactionManager;
    public function __construct
    (
        EntityManagerInterface            $em,
        FactureRepository                 $repository
    )
    {
        $this->em                       =  $em;
        $this->repository               =  $repository;
    }

    public function init()
    {
        return new Facture();
    }

    public function save(Facture $facture)
    {
        if (!$facture instanceof Facture)
            return;
        $this->em->persist($facture);
        $this->em->flush();
    }

}