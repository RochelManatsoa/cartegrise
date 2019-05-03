<?php

namespace App\Repository;

use App\Entity\DossiersDomicileRecent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DossiersDomicileRecent|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossiersDomicileRecent|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossiersDomicileRecent[]    findAll()
 * @method DossiersDomicileRecent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiersDomicileRecentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossiersDomicileRecent::class);
    }

    // /**
    //  * @return DossiersDomicileRecent[] Returns an array of DossiersDomicileRecent objects
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
    public function findOneBySomeField($value): ?DossiersDomicileRecent
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
