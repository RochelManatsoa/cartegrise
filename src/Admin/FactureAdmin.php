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

final class FactureAdmin extends AbstractAdmin
{
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb->leftJoin($alias.'.transaction', 'trans')
        ->andWhere('trans.status =:status')
        ->setParameter('status', '00');

        // dd($qb->getQuery()->getSql());
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('id')
        // ->add('roles', CollectionType::class, [
        //         'required' => false,
        //         'by_reference' => false,
        //         'allow_add' => true,
        //         'allow_delete' => true,
        //         'prototype' => true,
        // ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        // ->add('email')
        // ->add('client.clientNom')
        // ->add('roles')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->add('id')
        ->add('dateDemande')
        ->add('commande.immatriculation')
        ->add('commande.status')
        ->add('transaction.transactionId')
        ->add('_action', null, [
            'actions' => [
                'facture' => [
                    'template' => 'CRUD/list__action_clone.html.twig'
                ]
            ],
            
        ])
        ;

        // dd($listMapper);
    }
}