<?php

namespace App\Repository;

use App\Entity\DossiersDCS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DossiersDCS|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossiersDCS|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossiersDCS[]    findAll()
 * @method DossiersDCS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiersDCSRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossiersDCS::class);
    }

    // /**
    //  * @return DossiersDCS[] Returns an array of DossiersDCS objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DossiersDCS
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
