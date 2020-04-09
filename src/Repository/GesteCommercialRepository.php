<?php

namespace App\Repository;

use App\Entity\GesteCommercial\GesteCommercial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GesteCommercial|null find($id, $lockMode = null, $lockVersion = null)
 * @method GesteCommercial|null findOneBy(array $criteria, array $orderBy = null)
 * @method GesteCommercial[]    findAll()
 * @method GesteCommercial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GesteCommercialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GesteCommercial::class);
    }

    // /**
    //  * @return GesteCommercial[] Returns an array of GesteCommercial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GesteCommercial
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
