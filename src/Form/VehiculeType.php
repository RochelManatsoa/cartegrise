<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cgpresent')
            ->add('immatriculation')
            ->add('vin')
            ->add('numformule')
            ->add('datecg',DateType::class, array(
                'widget' => 'single_text',
                ))
            ->add('vehiculeAncientitulaire')
            ->add('vehiculeCartegrise')
            ->add('vehiculeDemande')
            ->add('vehiculeClient')
            ->add('client')
            ->add('infosup')
            ->add('Titulaire')
            ->add('demande')
            ->add('cotitulaire')
            ->add('vehicule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
