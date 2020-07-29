<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use App\Entity\{Demande, TypeDemande, Commande, PreviewEmail};

final class PreviewEmailAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'preview-email';
    protected $baseRouteName = 'preview-email';
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $alias = $query->getRootAliases()[0];
        $qb
        ->orderBy($alias.'.id', 'desc')
        ->andWhere($alias.'.typeEmail < :typeEmailParam')
        ->setParameter('typeEmailParam', PreviewEmail::MAIL_RELANCE_DONE);
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
        $collection->add('sendRelance', $this->getRouterIdParameter().'/envoie-relance');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('id', null, [
            'attr' => [
                'readonly' => 'readonly'
            ],
            'disabled' => 'disabled'
        ])
        ->add('immatriculation', null, array(
            'attr' => [
                'readonly' => 'readonly'
            ],
            'disabled' => 'disabled'
            ))
        ->add('user.email', null, [
            'disabled' => 'disabled'
        ])
        ->add('sendAt', DateTimeType::class, [
            "label" => 'date d\'envoie',
            'widget' => 'single_text'
        ])
        ->add('typeEmail', ChoiceType::class, [
            "label" => 'Type',
            'choices' => PreviewEmail::TYPES_EMAILS_FORM,
        ])
        ->add('status', ChoiceType::class, [
            "label" => 'Status',
            'choices' => [
                'En attente' => PreviewEmail::STATUS_PENDING,
                'Envoyer' => PreviewEmail::STATUS_SENT,
            ]
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('user.email', null, [
            'label' => 'email'
        ])
        ->add('user.client.clientNom', null, [
            'label' => 'Nom'
        ])
        ->add('immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->add('typeEmail', 'doctrine_orm_choice' ,[
            'label' => 'Type d\'email',
            'global_search' => true,
            'field_type' => ChoiceType::class,
            'field_options' => [
                'choices' => [
                    'Relance Demarche' => PreviewEmail::MAIL_RELANCE_DEMARCHE,
                    'Relance Paiement' => PreviewEmail::MAIL_RELANCE_PAIEMENT,
                ]
            ]
        ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('typeEmailString', null, [
            'label' => 'Type'
        ])
        ->add('user.client.clientNom', null, [
            'label' => 'Nom'
        ])
        ->add('user.email', null, [
            'label' => 'Email'
        ])
        ->add('commande.id', null, [
            'label' => 'Id de la commande'
        ])
        ->add('immatriculation', null, [
            'label' => 'Immatriculation'
        ])
        ->add('sendAt', null, [
            'label' => 'Date d\'envoie'
        ])
        ->add('statusString', ChoiceType::class, [
            "label" => 'Status',
            
        ])
        ->add('_action', null, [
            'actions' => [ 
                'envoyer' => [
                    'template'=>'CRUD/send_relance.html.twig'
                ]
            ],
            
        ])
        ;
    }
}