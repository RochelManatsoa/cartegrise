<?php

namespace App\Form;

use App\Entity\Duplicata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                ]
            ])
            ->add('demandeChangementTitulaire')
            ->add('titulaire', AncientitulaireType::class) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Duplicata::class,
        ]);
    }
}
