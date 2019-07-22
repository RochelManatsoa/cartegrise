<?php

namespace App\Manager;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\DailyFacture;
use App\Manager\Model\ParamDocumentAFournir;
use App\Repository\DailyFactureRepository;

class DailyFactureManager
{
    private $entityManager;
    private $serializer;
    private $repository;
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        DailyFactureRepository $repository
    )
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->repository = $repository;
    }

    public function init()
    {
        return new DailyFacture();
    }

    public function save(DailyFacture $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}