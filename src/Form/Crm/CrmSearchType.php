<?php

namespace App\Form\Crm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Manager\Crm\Modele\CrmSearch;

class CrmSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Email', TextType::class, [
            'required' => false,
        ])
        ->add('Immatriculation', TextType::class, [
            'required' => false,
        ])
        ->add('Nom', TextType::class, [
            'required' => false,
        ])
        ->add('Chercher', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CrmSearch::class,
        ]);
    }
}