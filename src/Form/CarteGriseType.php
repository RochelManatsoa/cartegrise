<?php

namespace App\Form;

use App\Entity\Cartegrise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarteGriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typevehicule')
            ->add('cgdepartement')
            ->add('modele')
            ->add('energie')
            ->add('cv')
            ->add('datecirculation')
            ->add('co2')
            ->add('ptac')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cartegrise::class,
        ]);
    }
}
