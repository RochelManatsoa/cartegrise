<?php

namespace App\Form;

use App\Entity\Ctvo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\{AncientitulaireType, NewtitulaireType};
use App\Form\CotitulairesType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CtvoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ancienTitulaire', AncientitulaireType::class, array('label'=>'label.ancienTitulaire'))            
            ->add('ciPresent', ChoiceType::class, array(
                'label' => 'label.ctvo.ciPresent',
                'choices' => array(
                    'Non' => Ctvo::CI_KO,
                    'Oui' => Ctvo::CI_OK,
                ),
                'attr' => [
                    'class' => 'choice-type-ciPresent'
                ]
            ))            
            ->add('numeroFormule', null, ['label' => 'label.numeroFormule', 'required' => false])
            // ->add('dateCi', DateType::class, array(
            //     'label'=>"label.ctvo.DateCI",
            //    'format' => 'dd-MM-yyyy',
            //     'widget' => 'single_text',
            //     'required' => false,
            //     ))
            ->add('acquerreur', NewtitulaireType::class, array('label'=>'label.ctvo.titulaire'))
            ->add('cotitulaire', CollectionType::class, [
                'label' => 'label.cotitulaire',
                'entry_type' => CotitulairesType::class,
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
            'data_class' => Ctvo::class,
        ]);
    }
}
