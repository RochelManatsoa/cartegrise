<?php

namespace App\Form;

use App\Form\VehiculeNeufType;
use App\Form\CaracteristiqueTechType;
use App\Form\CarrossierType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoVehiculeNeufType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicule', VehiculeNeufType::class, array('label'=>'label.vehicule.info'))
            ->add('carrossier', CollectionType::class, [
                'label' => 'label.divn.carrossier',
                'entry_type' => CarrossierType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('caractTech', CollectionType::class, [
                'label' => 'label.divn.caracteristiqueTechniquePart',
                'entry_type' => CaracteristiqueTechType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}