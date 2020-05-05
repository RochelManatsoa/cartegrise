<?php

namespace App\Repository;

use App\Entity\Ancientitulaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ancientitulaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ancientitulaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ancientitulaire[]    findAll()
 * @method Ancientitulaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AncientitulaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ancientitulaire::class);
    }

    // /**
    //  * @return Ancientitulaire[] Returns an array of Ancientitulaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ancientitulaire
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
