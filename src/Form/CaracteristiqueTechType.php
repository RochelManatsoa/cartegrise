<?php

namespace App\Form;

use App\Entity\Vehicule\CaracteristiqueTech;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CaracteristiqueTechType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', ChoiceType::class, [
                'label'=>'label.divn.code', 
                'choices' => CaracteristiqueTech::CODE,
            ])
            ->add('valeur1', null, ['label'=>'label.divn.valeur1'])
            ->add('valeur2', null, ['label'=>'label.divn.valeur2', 'required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CaracteristiqueTech::class,
        ]);
    }
}
