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

final class DeleteCommandeAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'manage';
    protected $baseRouteName = 'manage';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb->where($alias.'.client IS NOT NULL');

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
        ->add('roles')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('deleteCommande', $this->getRouterIdParameter().'/delete-commandes');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('email')
        ->add('client.totalCommandes')
        ->add('_action', null, [
            'actions' => [
                'facture' => [
                    'template' => 'CRUD/list_action_delete_commande.html.twig'
                ]
            ],
            
        ])
        ;
    }
}