<?php

namespace App\Repository;

use App\Entity\DailyFacture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DailyFacture|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyFacture|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyFacture[]    findAll()
 * @method DailyFacture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyFactureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DailyFacture::class);
    }

    // /**
    //  * @return DailyFacture[] Returns an array of DailyFacture objects
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
    public function findOneBySomeField($value): ?DailyFacture
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
