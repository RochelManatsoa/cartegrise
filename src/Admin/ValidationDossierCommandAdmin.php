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
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use App\Entity\{Demande, TypeDemande, Commande};

final class ValidationDossierCommandAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'dossier-estimation';
    protected $baseRouteName = 'dossier-estimation';
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb
        ->orderBy($alias.'.id', 'desc')
        ->leftJoin($alias.'.transaction', 'transaction')
        ->andWhere('transaction.status = :success')
        ->setParameter('success', '00')
        ;

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('dossier', $this->getRouterIdParameter().'/dossier');
        $collection->add('uploadDossier', $this->getRouterIdParameter().'/upload_dossier');
        $collection->add('ficheClient', $this->getRouterIdParameter().'/fiche-client');
        $collection->add('retracterWithDocument', $this->getRouterIdParameter().'/retracter');
        $collection->add('retracterCommande', $this->getRouterIdParameter().'/retracter-commande');
        $collection->add('refund', $this->getRouterIdParameter().'/refund');
        $collection->add('facture', $this->getRouterIdParameter().'/facture');
        $collection->add('factureCommande', $this->getRouterIdParameter().'/facture-commande');
        $collection->add('avoir', $this->getRouterIdParameter().'/avoir');
        $collection->add('avoirCommande', $this->getRouterIdParameter().'/avoir-commande');
        $collection->add('retracterCommandeSecond', $this->getRouterIdParameter().'/retracter-commande-second');
        $collection->add('refundCommande', $this->getRouterIdParameter().'/refund-commande');
        $collection->add('formulaireDemande', $this->getRouterIdParameter().'/form-demande-commande');
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
        ->add('comment')
        ->add('fraisRembourser')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('demarche.type', null, [
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
        ->add('client.user.email', null, [
            'label' => 'email'
        ])
        ->add('facture.createdAt', 'doctrine_orm_date_range', [
            'field_type'=> DateRangePickerType::class,
            'label' => 'payer le:'
        ])
        ->add('client.clientNom', null, [
            'label' => 'Nom'
        ])
        ->add('comment', null, [
            'label' => 'Commentaire'
        ])
        ->add('immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->add('demande.statusDoc', 'doctrine_orm_choice' ,[
            'label' => 'Etat',
            'global_search' => true,
            'field_type' => ChoiceType::class,
            'field_options' => [
                'choices' => [
                        'Attente de documents' => Demande::DOC_WAITTING,
                        'Documents numériques validés' => Demande::DOC_VALID,
                        'Documents numérisés' => Demande::DOC_PENDING,
                        'Documents incomplets' => Demande::DOC_UNCOMPLETED,
                        'Docs courrier validés' => Demande::DOC_RECEIVE_VALID,
                        'Documents reçus mais non validés' => Demande::DOC_NONVALID,
                        'Validée et envoyée à TMS' => Demande::DOC_VALID_SEND_TMS,
                        'Retractée' => Demande::RETRACT_DEMAND,
                        'Remboursée' => Demande::RETRACT_REFUND,
                        'Attente formulaire de rétractation' => Demande::RETRACT_FORM_WAITTING,
                ]
            ]
        ])
        ->add('statusTmp', 'doctrine_orm_choice' ,[
            'label' => 'Etat du document payer',
            'global_search' => true,
            'field_type' => ChoiceType::class,
            'field_options' => [
                'choices' => [
                        'Retractée' => Commande::RETRACT_DEMAND,
                        'Remboursée' => Commande::RETRACT_REFUND,
                        'Attente formulaire de rétractation' => Demande::RETRACT_FORM_WAITTING,
                ]
            ]
        ])
        ->add('without_demande', 'doctrine_orm_callback', array(
//                'callback'   => array($this, 'getWithOpenCommentFilter'),
                'label' => 'En attente de demande',
                'callback' => function($queryBuilder, $alias, $field, $value) {
                    if (!$value) {
                        return;
                    }

                    $queryBuilder->leftJoin(sprintf('%s.demande', $alias), 'd');
                    $queryBuilder->andWhere('d.id IS NULL');
                    return true;
                },
                'field_type' => CheckboxType::class
        ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('demarche.type', null, [
            'label' => 'Type'
        ])
        ->add('client.clientNom', null, [
            'label' => 'Nom'
        ])
        ->add('facture.createdAt', null, [
            'label' => 'Payée le'
        ])
        ->add('client.clientContact.contact_telmobile', null , [
            'label' => 'Téléphone'
        ])
        ->add('client.user.email', null, [
            'label' => 'Email'
        ])
        ->addIdentifier('clientName', null, [
            'label' => 'Profil',
            'template' => 'CRUD/client/ficheClientList.html.twig',
        ])
        ->add('immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->add('comment', null, [
            'label' => 'Commentaire'
        ])
        ->addIdentifier('factureAvoir', null, [
            'label' => 'facture / avoir',
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
                'retracterCommande' => [
                    'template'=>'CRUD/list__commande_document_retracter.html.twig'
                ],
                'formDemande' => [
                    'template'=>'CRUD/list__commande_form_demande.html.twig'
                ],
                'gesteCommercial' => [
                    'template'=>'CRUD/gesteCommercial/gesteCommercialActionButton.html.twig'
                ]
            ],
            
        ])
        ;
    }
}