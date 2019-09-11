<?php

namespace App\Form;

use App\Entity\Duplicata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\AncientitulaireType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DuplicataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motifDemande', ChoiceType::class, [
                'choices' => [
                    Duplicata::PERT => "PERT",
                    Duplicata::VOL  => "VOL",
                    Duplicata::DET  => "DET",
                ],
                'label' => 'label.motifDemande',
            ])
            ->add('datePerte', DateType::class, array(
                'label'=>"label.dup.datePerte",
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'js-datepicker', 'placeholder' => 'dd/mm/yyyy'],
                ))
            //->add('demandeChangementTitulaire', null, ['label' => 'label.demandeChangementTitulaire'])
            ->add('numeroFormule', null, [
                    'label' => 'label.numeroFormule',
                    'required' => false,
                    'label_attr' => [
                        'style' => 'display:inline',
                    ],
                ])
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
