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

final class AvoirAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'avoir';
    protected $baseRouteName = 'avoir';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb->leftJoin($alias.'.transaction', 'transCommande')
        ->leftJoin($alias.'.demande', 'demande')
        ->leftJoin($alias.'.avoir', 'commandeAvoir')
        ->leftJoin('demande.transaction', 'transDemande')
        ->andWhere('transDemande.status =:status OR transCommande.status =:status')
        ->andWhere('commandeAvoir.id IS NOT NULL')
        ->setParameter('status', '00');

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('avoir', $this->getRouterIdParameter().'/avoir');
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
        $collection->add('commandeFacture', $this->getRouterIdParameter().'/commandeFacture');
        $collection->add('avoirCommande', $this->getRouterIdParameter().'/avoirCommande');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('id', null, [
            'disabled' => true,
        ])
        ->add('fraisRembourser')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('immatriculation')
        ->add('avoir.createdAt', 'doctrine_orm_date_range',[
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
        ->add('demarche.type', null, [
            'label' => 'Type'
        ])
        ->add('avoir.createdAt', null,[
            'label' => 'Créé le',
        ])
        ->addIdentifier('demarche.nom', null, [
            'label' => 'Type de commande'
        ])
        ->addIdentifier('immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->addIdentifier('client.clientNom', null, [
            'label' => 'Nom'
        ])
        ->addIdentifier('status', null, [
            'label' => 'Statut'
        ])
        ->addIdentifier('comment', null, [
            'label' => 'Commentaire',
            'template' => 'CRUD/row/comment.html.twig',
        ])
        ->addIdentifier('factureAvoir', null, [
            'label' => 'facture / avoirs',
            'template' => 'CRUD/commande/factureAvoir.html.twig',
        ])
        ->addIdentifier('codePostal', null, [
            'label' => 'Dép.'
        ])
        ->addIdentifier('taxes.taxeTotale', null, [
            'label' => 'Taxes'
        ])
        ->addIdentifier('fraisTreatment', null, [
            'label' => 'Prestation',
            'template' => 'CRUD/prestation.html.twig',
        ])
        ->addIdentifier('remboursementTaxe', null, [
            'label' => 'Remboursement taxe',
            'template' => 'CRUD/remboursement/prestation.html.twig',
        ])
        ->addIdentifier('fraisRembourser', null, [
            'label' => 'Remboursement prestation',
        ])
        ;
    }
}