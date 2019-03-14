<?php

namespace App\Repository;

use App\Entity\TypeDemande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeDemande|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDemande|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDemande[]    findAll()
 * @method TypeDemande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDemandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeDemande::class);
    }

    // /**
    //  * @return TypeDemande[] Returns an array of TypeDemande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneByType($value): ?TypeDemande
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.type = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByNom($value): ?TypeDemande
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.nom = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
