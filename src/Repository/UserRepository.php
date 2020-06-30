<?php

namespace App\Repository;

use App\Entity\{User, Transaction};
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countDemande($user)
    {
        return $this->createQueryBuilder('u')
            ->select('count(d)')
            ->leftJoin('u.client','cl')
            ->leftJoin('cl.commandes','com')
            ->leftJoin('com.demande','d')
            ->where('u = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function countCommandeUnchecked($user)
    {
        return $this->createQueryBuilder('u')
            ->select('count(com)')
            ->leftJoin('u.client','cl')
            ->leftJoin('cl.commandes','com')
            ->where('com.demande IS NULL')
            ->andWhere('u = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function checkDemande(User $user)
    {
        return $this->createQueryBuilder('u')
            ->select('count(d)')
            ->leftJoin('u.client','cl')
            ->leftJoin('cl.commandes','com')
            ->leftJoin('com.demande','dem')
            ->leftJoin('dem.transaction','d')
            ->where('d.status = :success')
            ->andWhere('u = :user')
            ->setParameter('user', $user)
            ->setParameter('success', Transaction::STATUS_SUCCESS)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findUserForRelance($level = 0)
    {
        $date = $this->relanceDate($level);
        return $this->createQueryBuilder('u')
            ->leftJoin('u.client','cl')
            ->leftJoin('cl.commandes','com')
            ->where('cl.countDemande = :zero')
            ->andWhere('cl IS NOT NULL')
            //->andWhere('com.transaction IS NULL')
            ->andWhere('u.registerDate <= :date')
            ->andWhere('cl.relanceLevel =:level')
            ->setParameter('zero', 0)
            ->setParameter('level', $level)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    private function relanceDate($level)
    {
        $date = new \DateTime();
        switch($level){
            case 0:
                $date->modify('-1day');
                break;
            case 1:
                $date->modify('-3day');
                break;
            default:
                break;
        }

        return $date;
    }

    public function findUserAfterSuccessPaiment($level = 0)
    {
        $date = $this->relanceDateAfterSuccess($level);
        return $this->createQueryBuilder('u')
            ->leftJoin('u.client','cl')
            ->leftJoin('cl.commandes','com')
            ->leftJoin('com.transaction','t')
            ->leftJoin('com.demande','d')
            ->where('t.status = :success')
            ->andWhere('d IS NULL')
            ->andWhere('t.createAt = :date')
            ->andWhere('cl.relanceLevel =:level')
            ->setParameter('success', Transaction::STATUS_SUCCESS)
            ->setParameter('level', $level)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    private function relanceDateAfterSuccess($level)
    {
        $date = new \DateTime();
        switch($level){
            case 0:
                $date->modify('-1hour');
                break;
            case 1:
                $date->modify('-1day');
                break;
            default:
                break;
        }

        return $date;
    }


    public function findUserWithoutEstimation()
    {
        $result =  $this->createQueryBuilder('u')
            ->select('u.email, cl.clientNom nom, cl.clientPrenom prenom, cl.clientGenre genre, contact.contact_telmobile telephone')
            ->leftJoin('u.client','cl')
            ->leftJoin('cl.clientContact','contact')
            ->leftJoin('cl.commandes','commande')
            ->where('commande IS NULL')
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }

    public function findUserWithoutPayedCommand()
    {
        $result = $this->createQueryBuilder('u')
            ->select('u.email, cl.clientNom nom, cl.clientPrenom prenom, cl.clientGenre genre, contact.contact_telmobile telephone, com.codePostal departement, com.immatriculation immat, com.ceerLe creation')
            ->leftJoin('u.client', 'cl')
            ->leftJoin('cl.clientContact', 'contact')
            ->leftJoin('cl.commandes', 'com')
            ->leftJoin('com.transaction', 't')
            ->where('com IS NOT NULL')
            ->andWhere('t.status = :success')
            ->setParameter(':success', Transaction::STATUS_SUCCESS)
            ->getQuery()
            ->getResult()
        ;

        return $result;
    }
}
