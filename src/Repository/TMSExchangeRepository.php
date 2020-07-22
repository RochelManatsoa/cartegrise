<?php

namespace App\Repository;

use App\Entity\TMSExchange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TMSExchange|null find($id, $lockMode = null, $lockVersion = null)
 * @method TMSExchange|null findOneBy(array $criteria, array $orderBy = null)
 * @method TMSExchange[]    findAll()
 * @method TMSExchange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TMSExchangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TMSExchange::class);
    }

    // /**
    //  * @return TMSExchange[] Returns an array of TMSExchange objects
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
    public function findOneBySomeField($value): ?TMSExchange
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
