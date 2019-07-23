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

final class ValidationDossierAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'dossier';
    protected $baseRouteName = 'dossier';
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        // $qb->leftJoin($alias.'.transaction', 'trans')
        $qb->andWhere($alias.'.statusDoc IS NOT NULL');

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        // $collection->clearExcept(['dossier']);
        $collection->add('dossier', $this->getRouterIdParameter().'/dossier');
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
        ->add('reference')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->add('id')
        ->add('reference')
        ->add('dateDemande')
        ->add('commande.immatriculation')
        ->add('commande.status')
        ->add('transaction.transactionId')
        ->add('_action', null, [
            'actions' => [ 
                'dossier' => [
                    'template'=>'CRUD/list__demande_document.html.twig'
                ]
            ],
            
        ])
        ;
    }
}