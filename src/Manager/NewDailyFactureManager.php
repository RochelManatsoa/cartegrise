<?php

namespace App\Manager;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\NewDailyFacture;
use App\Manager\Model\ParamDocumentAFournir;
use App\Repository\NewDailyFactureRepository;

class NewDailyFactureManager
{
    private $entityManager;
    private $serializer;
    private $repository;
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        NewDailyFactureRepository $repository
    )
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->repository = $repository;
    }

    public function init()
    {
        return new NewDailyFacture();
    }

    public function save(NewDailyFacture $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}