<?php

namespace App\Form;

use App\Entity\Ancientitulaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AncientitulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'label' => 'label.type.personne',
                'choices' => array(
                    'Personne Physique' => "phy",
                    'Personne Morale' => "mor",
                ),
                'attr' => [
                    'class' => 'choice-type-ancientitulaire'
                ]
            ))
            ->add('raisonsociale', TextType::class, [
                'label'=> 'label.raisonsocial',
                'required' => false,
                ]
            )
            ->add('nomprenom', TextType::class, array(
                'label'=> 'label.nomprenom',
                'required' => false,
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ancientitulaire::class,
        ]);
    }
}
