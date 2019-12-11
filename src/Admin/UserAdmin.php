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

final class UserAdmin extends AbstractAdmin
{
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
        $collection->add('ficheClient', $this->getRouterIdParameter().'/fiche-client');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->addIdentifier('email')
        ->add('client.clientContact.contact_telmobile', null, [
            'label' => 'télephone'
        ])
        ->addIdentifier('nameClient', null, [
            'label' => 'Nom',
            'template' => 'CRUD/client/ficheClientList.html.twig',
        ])
        ->add('client.clientPrenom')
        ->add('roles')
        ;
    }
}