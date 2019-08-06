<?php

namespace App\Form;

use App\Entity\Vehicule\CaracteristiqueTechVehiculeNeuf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CaracteristiqueTechVehiculeNeufType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', ChoiceType::class, [
                'label'=>'label.code', 
                'choices' => CaracteristiqueTechVehiculeNeuf::CODE,
            ])
            ->add('valeur1', TextType::class, ['label'=>'label.valeur1'])
            ->add('valeur2', TextType::class, ['label'=>'label.valeur2'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CaracteristiqueTechVehiculeNeuf::class,
        ]);
    }
}
