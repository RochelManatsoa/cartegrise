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
use App\Entity\Systempay\Transaction;

final class GesteCommercialAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb->orderBy($alias.'.id', 'DESC')
        ->andWhere($alias.'.systempayTransaction IS NOT NULL')
        ->leftJoin($alias.'.systempayTransaction', 'systempay')
        ->andWhere('systempay.status = :success')
        ->setParameter('success', Transaction::TRANSACTION_SUCCESS);

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('ceerLe', DateType::class,[
            'label' => 'créer le:',
            'widget' => 'single_text',
            'disabled' => true,
        ])
        ->add('demarche.nom', TextType::class,[
            'disabled' => true,
        ])
        ->add('codePostal', TextType::class,[
            'disabled' => true,
        ])
        ->add('immatriculation', TextType::class,[
            'disabled' => true,
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('ceerLe', 'doctrine_orm_date_range', [
            'field_type'=> DateRangePickerType::class
        ])
        ->add('demarche.nom', null, [
            'label' => 'Type de commande'
        ])
        ->add('codePostal')
        ->add('immatriculation');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
        $collection->add('commandeFacture', $this->getRouterIdParameter().'/commandeFacture');
        $collection->add('avoir', $this->getRouterIdParameter().'/avoir');
        $collection->add('ficheClient', $this->getRouterIdParameter().'/fiche-client');
        $collection->add('gesteCommercial', $this->getRouterIdParameter().'/geste-comercial');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('demarche.type', null, [
            'label' => 'Type'
        ])
        ->addIdentifier('ceerLe', null, [
            'label' => 'Date commande',
        ])
        ->addIdentifier('demarche.nom', null, [
            'label' => 'Type de commande'
        ])
        ->addIdentifier('immatriculation')
        ->addIdentifier('nameClient', null, [
            'label' => 'Nom',
            'template' => 'CRUD/client/ficheClientList.html.twig',
        ])
        ->addIdentifier('status', null, [
            'label' => 'Statut Commande'
        ])
        ->addIdentifier('codePostal')
        ->addIdentifier('taxes.taxeTotale', null, [
            'label' => 'Taxes'
        ])
        ->addIdentifier('action', null, [
            'label' => 'Action',
            'template' => 'CRUD/gesteCommercial/gestComercialAction.html.twig',
        ])
        ;
    }
}