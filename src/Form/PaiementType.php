<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false,
                'label' => 'label.termsAccepted',
                'constraints' => new IsTrue(),
            ])
            ->add('enregistrer', SubmitType::class, 
            [
                'label' => 'label.paid',
                'attr' => [
                    'class' => 'btn-validate-command d-flex align-items-center justify-content-between btn btn-blue'
                ]
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
