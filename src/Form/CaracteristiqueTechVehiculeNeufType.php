<?php

namespace App\Form;

use App\Entity\Vehicule\CaracteristiqueTechVehiculeNeuf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaracteristiqueTechVehiculeNeufType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('valeur1')
            ->add('valeur2')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CaracteristiqueTechVehiculeNeuf::class,
        ]);
    }
}
