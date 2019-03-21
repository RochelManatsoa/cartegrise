<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CtvoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('AncienTitulaire', AncientitulaireType::class)            
            ->add('Acquerreur', NewtitulaireType::class, array('label'=>"Nouveau titulaire"))
            ->add('Vehicule', VehiculeType::class, array('label'=>"Information véhicule"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
