<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

final class ConfigurationAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('keyConf', TextType::class,[
            'attr' => [
                // 'readonly'=>true,
            ]
        ])
        ->add('DC', CheckboxType::class, [
            'label' => 'home.commandeType.dc',
            'required' => false,
        ])
        ->add('DCA', CheckboxType::class, [
            'label' => 'home.commandeType.dca',
            'required' => false,
        ])
        ->add('DUP', CheckboxType::class, [
            'label' => 'home.commandeType.dup',
            'required' => false,
        ])
        ->add('CTVO', CheckboxType::class, [
            'label' => 'home.commandeType.ctvo',
            'required' => false,
        ])
        ->add('DIVN', CheckboxType::class, [
            'label' => 'home.commandeType.divn',
            'required' => false,
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('keyConf')
        ->add('DC')
        ->add('DCA')
        ->add('DUP')
        ->add('CTVO')
        ->add('DIVN')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->addIdentifier('keyConf')
        ->add('DC')
        ->add('DCA')
        ->add('DUP')
        ->add('CTVO')
        ->add('DIVN')
        ;
    }
}