<?php

namespace App\Form;

use App\Form\VehiculeNeufType;
use App\Form\CaracteristiqueTechVehiculeNeufType;
use App\Form\CarrosierVehiculeNeufType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeNeufInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicule', VehiculeNeufType::class, array('label'=>'label.vehicule.info'))
            ->add('carrosier', CarrosierVehiculeNeufType::class, array('label'=>'label.carrossier'))
            ->add('caractTech', CollectionType::class, [
                'label' => 'label.caracteristiqueTechniquePart',
                'entry_type' => CaracteristiqueTechVehiculeNeufType::class,
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
