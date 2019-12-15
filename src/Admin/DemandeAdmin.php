<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use Sonata\AdminBundle\Route\RouteCollection;

final class DemandeAdmin extends AbstractAdmin
{
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb->orderBy($alias.'.id', 'DESC');

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('commande', TextType::class,[
            'disabled' => true,
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('TmsIdDemande')
        ->add('commande.immatriculation')
        ->add('commande.ceerLe', 'doctrine_orm_date_range',[
            'field_type'=> DateRangePickerType::class,
        ])
        ->add('commande.demarche.nom', null, [
            'label' => 'Type de commande'
        ])
        ->add('commande.codePostal')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
        $collection->add('avoir', $this->getRouterIdParameter().'/avoir');
        $collection->add('retracter', $this->getRouterIdParameter().'/retracter');
        $collection->add('ficheClient', $this->getRouterIdParameter().'/fiche-client');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->addIdentifier('commande.ceerLe', null, [
            'label' => 'Date commande',
        ])
        ->addIdentifier('commande.demarche.nom', null, [
            'label' => 'Type de commande'
        ])
        ->add('commande.immatriculation')
        ->addIdentifier('clientName', null, [
            'label' => 'Nom',
            'template' => 'CRUD/client/ficheClientList.html.twig',
        ])
        ->addIdentifier('status', null, [
            'label' => 'Status Commande'
        ])
        ->addIdentifier('notification', null, [
            'label' => 'Notification'
        ])
        ->addIdentifier('factureAvoir', null, [
            'label' => 'facture / avoirs',
            'template' => 'CRUD/demande/factureAvoir.html.twig',
        ])
        ->addIdentifier('codePostal')
        ->addIdentifier('commande.taxes.taxeTotale', null, [
            'label' => 'Taxes'
        ])
        ->addIdentifier('commande.fraisTreatment', null, [
            'label' => 'Prestation',
            'template' => 'CRUD/demande/prestation.html.twig',
        ])
        ->addIdentifier('commande.remboursementTaxe', null, [
            'label' => 'Remboursement taxe',
            'template' => 'CRUD/remboursement/prestation.html.twig',
        ])
        ->addIdentifier('remboursementTraitement', null, [
            'label' => 'Remboursement prestation',
            'template' => 'CRUD/remboursement/taxes.html.twig',
        ])
        ->addIdentifier('retracter', null, [
            'label' => 'Proceder au retractation',
            'template' => 'CRUD/demande/ratractation.html.twig',
        ])
        ;
    }
}