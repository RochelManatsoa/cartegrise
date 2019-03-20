<?php

namespace App\Form;

use App\Entity\AdresseNewTitulaire;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseNewTitulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroRue')
            ->add('extension')
            ->add('adprecision')
            ->add('typevoie')
            ->add('nomvoie')
            ->add('complement')
            ->add('lieudit')
            ->add('codepostal')
            ->add('ville')
            ->add('boitepostal')
            ->add('pays', CountryType::class, array('label' => 'Pays','required'=> false, 'preferred_choices' => array('FR'=>'France')))
            ->add('titulaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdresseNewTitulaire::class,
        ]);
    }
}
