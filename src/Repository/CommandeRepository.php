<?php

namespace App\Repository;

use App\Entity\{Commande, Transaction, User};
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.commande = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findByCommandeByClient(Client $client)
    {
        return $this->createQueryBuilder('c')
            ->join('c.client', 'client')
            ->andWhere('client = :val')
            ->setParameter('val', $client)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getDailyCommandeFacture($begin, \DateTime $now)
    {
        $qb = $this->createQueryBuilder('c')
        ->join('c.facture','fact')
        // ->join('c.client','cli')
        // ->join('cli.user','u')
        ->distinct()
        // ->where('trans.status =:paramSuccess')
        ->where('fact.createdAt <= :now');
        // ->andWhere('trans.amount IS NOT NULL')
        // ->andWhere('trans.createAt <= :now');

        $qb
        // ->setParameter('paramSuccess', Transaction::STATUS_SUCCESS)
        ->setParameter('now', $now);
        // dd($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();
    }
    public function getDailyCommandeFactureLimitate(\DateTime $start, \DateTime $end)
    {
        // $now->modify('- 40day');
        $qb = $this->createQueryBuilder('c')
        // ->select('u.email, c.clientNom, c.clientPrenom, c.id as idClient, c.clientGenre')
        ->join('c.facture','fact')
        // ->join('c.client','cli')
        // ->join('cli.user','u')
        ->distinct()
        // ->where('trans.status =:paramSuccess')
        // ->andWhere('trans.amount IS NOT NULL')
        // ->andWhere('trans.createAt <= :end')
        ->where('fact.createdAt <= :end')
        ->andWhere('fact.createdAt > :start');

        $qb
        // ->setParameter('paramSuccess', Transaction::STATUS_SUCCESS)
        ->setParameter('start', $start)
        ->setParameter('end', $end);
        // dd($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();
    }
    
}
