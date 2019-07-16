<?php

namespace App\Form;

use App\Entity\DivnInit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DivnInitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add("department", null, [
            'attr' => [
                'class' => 'row',
            ],
            'label' => 'label.dep'
        ])
        ->add("genre", ChoiceType::class, [
            "choices" => DivnInit::GENDERS,
            'attr' => [
                'class' => 'row',
            ],
            'label' => 'label.divn.genre'
        ])
        ->add("puissanceFiscale", null, [
            'attr' => [
                'class' => 'row',
            ],
            'label' => 'label.divn.puissanceFiscale'
        ])
        ->add("energie", ChoiceType::class, [
            "choices" => DivnInit::ENERGIES,
            'attr' => [
                'class' => 'row',
            ],
            'label' => 'label.divn.energie'
        ])
        ->add("tauxDeCo2", null, [
            'attr' => [
                'class' => 'row',
            ],
            'label' => 'label.divn.tauxDeCo2'
        ])
        ->add("Marque", TextType::class, [
            'attr' => [
                'class' => 'row',
            ],
            'label' => 'label.divn.marque'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
                [
                    'data_class' => DivnInit::class
                ]
            );
    }
}