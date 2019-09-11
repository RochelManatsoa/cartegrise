<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;

final class StatisticAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'statistic';
    protected $baseRouteName = 'statistic';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('ceerLe', DateType::class,[
            'label' => 'créer le:',
            'format' => 'dd-MM-yyyy',
            'widget' => 'single_text',
            'html5' => false,
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
        ->add('demarche.nom')
        ->add('codePostal')
        ->add('ceerLe', 'doctrine_orm_date_range' , [
            'field_type'=> DateRangePickerType::class,
        ])
        ->add('immatriculation');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->addIdentifier('demarche.nom')
        ->addIdentifier('immatriculation')
        ->addIdentifier('status')
        ->addIdentifier('ceerLe')
        ->addIdentifier('codePostal')
        ;
    }
}