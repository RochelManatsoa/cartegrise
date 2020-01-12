<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Route\RouteCollection;
use App\Entity\Demande;

final class ValidationDossierAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'dossier';
    protected $baseRouteName = 'dossier';
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb
        ->orderBy($alias.'.id', 'desc')
        ;

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('dossier', $this->getRouterIdParameter().'/dossier');
        $collection->add('uploadDossier', $this->getRouterIdParameter().'/upload_dossier');
        $collection->add('ficheClient', $this->getRouterIdParameter().'/fiche-client');
        $collection->add('retracterWithDocument', $this->getRouterIdParameter().'/retracter');
        $collection->add('refund', $this->getRouterIdParameter().'/refund');
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
        $collection->add('avoir', $this->getRouterIdParameter().'/avoir');
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
        ->add('commande.client.user.email', null, [
            'label' => 'email'
        ])
        ->add('commande.client.clientNom', null, [
            'label' => 'Nom'
        ])
        ->add('commande.immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->add('statusDoc', 'doctrine_orm_choice' ,[
            'label' => 'Etat',
            'global_search' => true,
            'field_type' => ChoiceType::class,
            'field_options' => [
                'choices' => [
                        'attente de document' => Demande::DOC_WAITTING,
                        'document valide' => Demande::DOC_VALID,
                        'document numériser' => Demande::DOC_PENDING,
                        'documents incomplets ' => Demande::DOC_UNCOMPLETED,
                        'document reçus' => Demande::DOC_RECEIVE_VALID,
                        'documents reçus mais non validés' => Demande::DOC_NONVALID,
                        'validé et envoyé à TMS' => Demande::DOC_VALID_SEND_TMS,
                        'retracté' => Demande::RETRACT_DEMAND,
                        'remboursé' => Demande::RETRACT_REFUND,
                        'attente formulaire de rétractation' => Demande::RETRACT_FORM_WAITTING,
                ]
            ]
        ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->add('id')
        ->add('commande.client.clientNom', null, [
            'label' => 'Nom'
        ])
        ->add('commande.client.clientContact.contact_telmobile', null , [
            'label' => 'Telephone'
        ])
        ->add('dateDemande')
        ->add('commande.client.user.email', null, [
            'label' => 'email'
        ])
        ->addIdentifier('clientName', null, [
            'label' => 'Profil',
            'template' => 'CRUD/client/ficheClientList.html.twig',
        ])
        ->add('commande.immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->addIdentifier('factureAvoir', null, [
            'label' => 'facture / avoirs',
            'template' => 'CRUD/demande/factureAvoir.html.twig',
        ])
        ->add('statusDocStringDesigned', null, [
            'label' => "Etat",
            'template' => 'CRUD/statusDocDesigned.html.twig',
        ])
        ->add('_action', null, [
            'actions' => [ 
                'dossier' => [
                    'template'=>'CRUD/list__demande_document.html.twig'
                ],
                'upload' => [
                    'template'=>'CRUD/list__demande_document_upload.html.twig'
                ],
                'retracter' => [
                    'template'=>'CRUD/list__demande_document_retracter.html.twig'
                ]
            ],
            
        ])
        ;
    }
}