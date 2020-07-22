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

final class TmsAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'tms';
    protected $baseRouteName = 'tms';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        // $qb->leftJoin($alias.'.transaction', 'transDemande')
        // ->leftJoin($alias.'.commande', 'commande')
        // ->leftJoin($alias.'.avoir', 'demandeAvoir')
        // ->leftJoin('commande.transaction', 'transCommande')
        // ->andWhere('transDemande.status =:status OR transCommande.status =:status')
        // ->andWhere('demandeAvoir.id IS NOT NULL')
        // ->setParameter('status', '00');

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('avoir', $this->getRouterIdParameter().'/avoir');
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('id', null, [
            'disabled' => true,
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('type')
        ->add('createdAt', 'doctrine_orm_date_range',[
            'label' => 'Créé le:',
            'field_type'=> DateRangePickerType::class,
        ])
        ->add('id')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('type', null, [
            'label' => 'Type'
        ])
        ->add('createdAt', null,[
            'label' => 'Créé le',
        ])
        ->addIdentifier('parameters', null, [
            'label' => 'Parametre'
        ])
        ->addIdentifier('response', null, [
            'label' => 'Réponse'
        ])
        ;
    }
}