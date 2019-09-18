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
use App\Entity\Commande;
use App\Entity\Demande;
use App\Manager\StatusManager;

final class UploadDossierAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'upload_dossier';
    protected $baseRouteName = 'upload_dossier';
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $qb = $query->getQueryBuilder();
        $statusManager = new StatusManager();
        $alias = $query->getRootAliases()[0];
        // $qb->leftJoin($alias.'.transaction', 'trans')
        $qb
        ->leftJoin($alias.'.transaction', 'trans')
        ->andWhere($alias.'.statusDoc IS NULL OR '.$alias.'.statusDoc =:statusDoc')
        ->andWhere('trans.status =:status')
        ->setParameter('status', "00")
        ->setParameter('statusDoc', Demande::DOC_NONVALID)
        ;

        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        // $collection->clearExcept(['dossier']);
        $collection->add('uploadDossier', $this->getRouterIdParameter().'/upload_dossier');
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
        ->add('commande.immatriculation')
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
                'upload' => [
                    'template'=>'CRUD/list__demande_document_upload.html.twig'
                ]
            ],
            
        ])
        ;
    }
}