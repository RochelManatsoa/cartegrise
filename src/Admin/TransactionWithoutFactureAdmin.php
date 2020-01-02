<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use App\Entity\Transaction;

final class TransactionWithoutFactureAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'transaction-sans-facture';
    protected $baseRouteName = 'transaction-sans-facture';

    public function createQuery($context = 'list')
    {
        $dateStart = new \DateTime('2019-11-21');
        $dateEnd = new \DateTime('2019-12-24');
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb->where($alias.'.createAt >= :dateStart')
        ->andWhere($alias.'.createAt <= :dateEnd')
        ->andWhere($alias.'.status = :statusOk')
        ->setParameter('statusOk', Transaction::STATUS_SUCCESS)
        ->setParameter('dateStart', $dateStart, \Doctrine\DBAL\Types\Type::DATETIME)
        ->setParameter('dateEnd', $dateEnd)
        ;

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('id')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('transactionId')
        ->add('createAt', 'doctrine_orm_date_range',[
            'field_type'=> DateRangePickerType::class,
            'label' => 'Créer le',
        ])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('remanance', $this->getRouterIdParameter().'/remanance');
        $collection->add('ficheClient', $this->getRouterIdParameter().'/fiche-client');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('transactionId')
        ->add('createAt', null, [
            'label' => 'Créer le'
        ])
        ->addIdentifier('infosClient', null, [
            'label' => 'Infos Client',
            'template' => 'admin/transaction/infosClient.html.twig',
        ])
        ;
    }
}