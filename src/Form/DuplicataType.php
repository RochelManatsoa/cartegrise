<?php

namespace App\Form;

use App\Entity\Duplicata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\AncientitulaireType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DuplicataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motifDemande', ChoiceType::class, [
                'choices' => [
                    Duplicata::VOL  => "VOL",
                    Duplicata::PERT => "PERT",
                    Duplicata::DET  => "DET",
                ],
                'label' => 'label.motifDemande',
                'attr' => [
                    'class'=>'choice-type-motifDemande'
                ]
            ])
            ->add('datePerte', DateType::class, array(
                'label'=>"label.dup.datePerte",
                'widget' => 'single_text',
                'required' => false,
                ))
            ->add('demandeChangementTitulaire', null, ['label' => 'label.demandeChangementTitulaire'])
            ->add('titulaire', AncientitulaireType::class, ['label' => 'label.titulaire']) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Duplicata::class,
        ]);
    }
}
