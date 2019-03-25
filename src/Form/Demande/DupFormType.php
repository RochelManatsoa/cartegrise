<?php

namespace App\Form\Demande;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Demande;
use App\Form\{AncientitulaireType, NewtitulaireType};

class DupFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motifDuplicata', ChoiceType::class, array(
                'label' => "Motif de la demande (*)",
                'required'=>true,
                'choices' => array(
                    'Perte' => "perte",
                    'Vol' => "vol",
                    'Détérioration' => "deter",
                ),
            ))
            ->add('liaisonDuplicata', CheckboxType::class, [
                'label'    => "Demande effectuée dans le cadre d'un changement de titulaire ou de cession",
                'required' => false,
            ])
            ->add('AncienTitulaire', AncientitulaireType::class)            
            // ->add('Acquerreur', NewtitulaireType::class, array('label'=>"Nouveau titulaire"))
            // ->add('Vehicule', VehiculeType::class, array('label'=>"Information véhicule"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
