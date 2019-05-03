<?php

namespace App\Repository;

use App\Entity\DossiersDCA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DossiersDCA|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossiersDCA|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossiersDCA[]    findAll()
 * @method DossiersDCA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiersDCARepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossiersDCA::class);
    }

    // /**
    //  * @return DossiersDCA[] Returns an array of DossiersDCA objects
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
    public function findOneBySomeField($value): ?DossiersDCA
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
