<?php

namespace App\Form;

use App\Entity\Vehicule\Carrossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarrossierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeCarrossier', ChoiceType::class, array(
                'label' => 'label.type.personne',
                'choices' => array(
                    'Personne Physique' => "phy",
                    'Société' => "mor",
                ),
                'attr' => [
                    'class' => 'choice-type-carrossier'
                ]
            ))
            ->add('agrement', null, [
                'label' => 'label.divn.agrement',
                'required' => false
            ])
            ->add('nomCarrosssier', null, [
                'label' => 'label.divn.nomCarrossier',
                'required' => false
            ])
            ->add('prenomCarrossier', null, [
                'label' => 'label.divn.prenomCarrossier',
                'required' => false
            ])
            ->add('raisonSocialCarrossier', null, [
                'label' => 'label.divn.raisonsocial',
                'required' => false
            ])
            ->add('justificatifs', null, [
                'label' => 'label.divn.justificatifs',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Carrossier::class,
        ]);
    }
}
