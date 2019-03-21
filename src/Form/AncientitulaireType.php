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
                'label' => "Personne (*)",
                'choices' => array(
                    'Personne Physique' => "phy",
                    'Personne Morale' => "mor",
                ),
            ))
            ->add('raisonsociale', TextType::class, array('label'=>"Raison sociale", 'required'=>false))
            ->add('nomprenom', TextType::class, array('label'=>"Nom et prénom(s) (*)"))
            // ->add('demande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ancientitulaire::class,
        ]);
    }
}
