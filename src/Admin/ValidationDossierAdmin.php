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
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use App\Entity\{Demande, Partner, TypeDemande};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
        ->where($alias.'.dateDemande <= :date')
        ->setParameter('date', '2020-06-11 23:59:59')
        ;

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('dossier', $this->getRouterIdParameter().'/dossier');
        $collection->add('uploadDossier', $this->getRouterIdParameter().'/upload_dossier');
        $collection->add('ficheClient', $this->getRouterIdParameter().'/fiche-client');
        $collection->add('retracterWithDocument', $this->getRouterIdParameter().'/retracter');
        $collection->add('retracter', $this->getRouterIdParameter().'/retracter-demande');
        $collection->add('refund', $this->getRouterIdParameter().'/refund');
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
        $collection->add('avoir', $this->getRouterIdParameter().'/avoir');
        $collection->add('gesteCommercial', $this->getRouterIdParameter().'/geste-comercial');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('id', null, [
            'attr' => [
                'readonly' => 'readonly'
            ]
        ])
        ->add('commande.comment', SimpleFormatterType::class, array(
            'label' => 'commentaire',
            'attr' => array('class' => 'ckeditor'),
            'format' => 'text'
            ))
        ->add('commande.partner', EntityType::class, array(
            'label' => 'Partenariat',
            'class' => Partner::class,
            'required' => false,
            'choice_label' => 'name',
            'attr' => array('class' => 'half', 'placeholder' => 'Selectionner dans la liste'),
            ))
        ->add('commande.commission', null, array(
                'label' => 'Commission',
                'attr' => array('class' => 'half'),
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('reference')
        ->add('commande.demarche.type', null , [
            'label' => 'Type',
            'global_search' => true,
            'field_type' => ChoiceType::class,
            'field_options' => [
                'choices' => [
                    'Changement de Titulaire Vehicule d\'ocasion' => TypeDemande::TYPE_CTVO,
                    'Duplicata' => TypeDemande::TYPE_DUP,
                    'Demande d\'immatriculation de véhicule neuf' => TypeDemande::TYPE_DIVN,
                    'Demande de changement d\'addresse' => TypeDemande::TYPE_DCA
                ]
            ]
        ])
        ->add('commande.client.user.email', null, [
            'label' => 'email'
        ])
        ->add('commande.partner.name', null, [
            'label' => 'Partenariat'
        ])
        ->add('commande.commission', null, [
            'label' => 'Commission'
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
        ->addIdentifier('id')
        ->add('commande.demarche.type', null, [
            'label' => 'Type'
        ])
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
        ->add('commande.comment', null, [
            'label' => 'Commentaire',
            'template' => 'CRUD/row/comment.html.twig',
        ])
        ->add('commande.partner.name', null, [
            'label' => 'Partenariat',
        ])
        ->add('commande.commission', null, [
            'label' => 'Commission',
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
                ],
                'gesteCommercial' => [
                    'template'=>'CRUD/gesteCommercial/gesteCommercialActionButton.html.twig'
                ]
            ],
            
        ])
        ;
    }
}