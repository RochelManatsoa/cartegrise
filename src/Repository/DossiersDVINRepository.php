<?php

namespace App\Repository;

use App\Entity\DossiersDVIN;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DossiersDVIN|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossiersDVIN|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossiersDVIN[]    findAll()
 * @method DossiersDVIN[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiersDVINRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossiersDVIN::class);
    }

    // /**
    //  * @return DossiersDVIN[] Returns an array of DossiersDVIN objects
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
    public function findOneBySomeField($value): ?DossiersDVIN
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
