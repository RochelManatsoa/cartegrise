<?php

namespace App\Repository;

use App\Entity\Demande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Manager\Crm\Modele\CrmSearch;
use App\Entity\User;

/**
 * @method Demande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demande[]    findAll()
 * @method Demande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Demande::class);
    }
    
    // /**
    //  * @return Demande[] Returns an array of Demande objects
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
    public function findOneBySomeField($value): ?Demande
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getDemandeForUser(User $user)
    {
        return $this->createQueryBuilder('d')
        ->join('d.commande','com')
        ->join('com.client','c')
        ->join('c.user','u')
        ->where('u =:user')
        ->setParameter('user', $user)->getQuery()->getResult();

    }



    public function getCrmFilter(CrmSearch $crmSearch)
    {
        if (!$crmSearch->isFilterable())
            return [];
        /**
         * search started
         */
        $builder = $this->createQueryBuilder('d');
        #filter email
        if (null != $crmSearch->getEmail()) {
            $builder
            ->join('d.commande', 'comm')
            ->join('comm.client', 'client')
            ->join('client.user', 'user')
            ->andWhere('user.email like :email')
            ->setParameter('email', '%'.$crmSearch->getEmail().'%');
        }
        #filter nom
        if (null != $crmSearch->getNom()) {
            if (null == $crmSearch->getEmail()) {
                $builder
                ->join('d.commande', 'comm')
                ->join('comm.client', 'client');
            }
            $builder
            ->andWhere('client.clientNom like :nom OR client.clientPrenom like :nom')
            ->setParameter('nom', '%'.$crmSearch->getNom().'%');
        }
        #filter immatriculation
        if (null != $crmSearch->getImmatriculation()) {
            if ((!$crmSearch->getNom() && !$crmSearch->getEmail())) {
            $builder
                ->join('d.commande', 'comm');
            }
            $builder
            ->andWhere('comm.immatriculation = :immatriculation')
            ->setParameter('immatriculation', $crmSearch->getImmatriculation());
        }

        return $builder->getQuery()->getResult();        
    }

}
