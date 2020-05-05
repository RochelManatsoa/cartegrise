<?php

namespace App\Repository;

use App\Entity\Taxes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method Taxes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taxes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taxes[]    findAll()
 * @method Taxes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Taxes::class);
    }

    // /**
    //  * @return Taxes[] Returns an array of Taxes objects
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

    /*
    public function findOneBySomeField($value): ?Taxes
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
