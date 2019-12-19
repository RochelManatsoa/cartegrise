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

final class RemananceClientAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'remanance';
    protected $baseRouteName = 'remanance';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb->leftJoin($alias.'.client', 'clientUser')
        ->andWhere('clientUser.countCommande >= :status OR clientUser.countDemande >= :status')
        ->setParameter('status', '2');

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('email')
        ->add('roles', CollectionType::class, [
                'required' => false,
                'by_reference' => false, 
                'allow_add' => true, 
                'allow_delete' => true, 
                'prototype' => true, 
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('email')
        ->add('client.clientNom')
        ->add('client.clientPrenom')
        ->add('roles')
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
        ->add('email', null, ['label'=>'Mail'])
        ->add('client.clientContact.contact_telmobile', null, [
            'label' => 'Télephone'
        ])
        ->addIdentifier('nameClient', null, [
            'label' => 'Nom',
            'template' => 'CRUD/client/ficheClientList.html.twig',
        ])
        ->add('client.clientPrenom', null, ['label'=>'Prénom(s)'])
        ->add('client.countDemande', null, ['label'=>'Demande'])
        ->add('client.countCommande', null, ['label'=>'Commande'])
        ;
    }
}