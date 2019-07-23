<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-06-20 12:57:00 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-06-20 13:15:30
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use App\Entity\NotificationEmail;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Form\Type\CollectionType;

final class NotificationEmailAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->add('keyConf', ChoiceType::class, [
            'choices' => [
                NotificationEmail::PAIMENT_NOTIF => NotificationEmail::PAIMENT_NOTIF,
                NotificationEmail::FILE_NOTIF => NotificationEmail::FILE_NOTIF,
            ], 
            'label' => 'label.notificationType'
        ])
        ->add('valueConf', CollectionType::class, [
                'label' => 'label.clientEmail',
                'required' => false,
                'by_reference' => false, 
                'allow_add' => true, 
                'allow_delete' => true, 
                'prototype' => true, 
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('id')
        ->add('keyConf')
        ->add('valueConf')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->addIdentifier('keyConf')
        ->add('valueConf')
        ;
    }
}