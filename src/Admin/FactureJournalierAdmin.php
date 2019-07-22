<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Route\RouteCollection;

final class FactureJournalierAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('dateCreate')
        ;
    }
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('facturejournalier', $this->getRouterIdParameter().'/facturejournalier');
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('dateCreate')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->add('id')
        ->add('dateCreate')
        ->add('_action', null, [
            'actions' => [
                'facturejournalier' => [
                    'template' => 'CRUD/list_action_facture_journalier.html.twig'
                ]
            ],
            
        ])
        ;
    }
}