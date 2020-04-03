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

final class FactureAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'facture';
    protected $baseRouteName = 'facture';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb
        ->orderBy($alias.'.id', 'DESC');

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('factureCommande', $this->getRouterIdParameter().'/facture');
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
        ->add('commande.immatriculation')
        ->add('commande.ceerLe', 'doctrine_orm_date_range',[
            'field_type'=> DateRangePickerType::class,
        ])
        ->add('id')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->add('id')
        ->add('commande.demarche.type', null, [
            'label' => 'Type'
        ])
        ->add('commande.ceerLe')
        ->add('commande.immatriculation')
        ->add('commande.status')
        ->add('commande.comment', null ,[
            'label' => 'Commentaire'
        ])
        ->add('commande.transaction.transactionId')
        ->add('_action', null, [
            'actions' => [
                'facture' => [
                    'template' => 'CRUD/list__action_facture.html.twig'
                ]
            ],
            
        ])
        ;
    }
}