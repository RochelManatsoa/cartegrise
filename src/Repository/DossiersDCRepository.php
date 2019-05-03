<?php

namespace App\Repository;

use App\Entity\DossiersDC;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DossiersDC|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossiersDC|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossiersDC[]    findAll()
 * @method DossiersDC[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiersDCRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DossiersDC::class);
    }

    // /**
    //  * @return DossiersDC[] Returns an array of DossiersDC objects
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
    public function findOneBySomeField($value): ?DossiersDC
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
