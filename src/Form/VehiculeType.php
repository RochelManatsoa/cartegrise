<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cgpresent')
            ->add('immatriculation', TextType::class, array('label' => 'Immatriculation'))
            ->add('vin', TextType::class, array('label' => 'VIN'))
            ->add('numformule', TextType::class, array('label' => 'Numéro de la formule'))
            ->add('datecg', DateType::class, array(
                'label'=>"Date de Carte Grise (*)",
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
