<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use App\Entity\{Notification, Commande, Demande, Transaction};
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

final class NotificationAdmin extends AbstractAdmin
{
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('subject', null, [
            'label' => 'Sujet'
        ])
        ->add('content', null, [
            'label' => 'Contenu'
        ])
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
        ->add('subject')
        ->add('createdAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->addIdentifier('subject')
        ->addIdentifier('commande.demarche.nom', null, [
            'label' => 'Type de commande'
        ])
        ->addIdentifier('commande.immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->addIdentifier('client.clientNom', null, [
            'label' => 'Nom client'
        ])
        ->addIdentifier('commande.status', null, [
            'label' => 'Status Commande'
        ])
        ->addIdentifier('demande.statutDemande', null, [
            'label' => 'Status Demande'
        ])
        ->addIdentifier('transaction.transaction_id', null, [
            'label' => 'Transaction ID'
        ])
        ->add('createdAt')
        ;
    }
}

