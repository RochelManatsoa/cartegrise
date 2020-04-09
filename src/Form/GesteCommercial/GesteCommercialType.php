<?php

namespace App\Form\GesteCommercial;

use App\Entity\GesteCommercial\GesteCommercial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\{CountryType, SubmitType};
use Symfony\Component\Validator\Constraints\IsTrue;

class GesteCommercialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxeFiscal', NumberType::class,[
                'attr'  => array( 'class' => 'text-uppercase' ),
                'label' => 'Taxe fiscal'
            ])
            ->add('fraisDossier', NumberType::class, [
                'label' => 'Frais de dossier'
                ])
            ->add('paied', CheckboxType::class, array(
                'label'=> 'Payer',
                'required' => false
            ))
            ->add('generer', SubmitType::class, [
                'attr' => [
                    'class' => 'save btn btn-primary',
                    'formtarget' => '_blank'
            ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GesteCommercial::class,
        ]);
    }
}