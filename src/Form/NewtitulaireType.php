<?php

namespace App\Form;

use App\Entity\NewTitulaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewtitulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomPrenomTitulaire', TextType::class, array('label'=>"Nom et prénom(s) du titulaire (*)"))
            ->add('genre', ChoiceType::class, array(
                'label' => "Sexe (*)",
                'choices' => array(
                    'Féminin' => "fem",
                    'Masculin' => "hom",
                ),
            ))
            ->add('dateN', DateType::class, array(
                'label'=>"Date de naissance (*)",
                'widget' => 'single_text',
                ))
            ->add('lieuN', TextType::class, array('label'=>"Lieu de naissance (*)"))
            // ->add('type')
            ->add('raisonSociale')
            ->add('societeCommerciale', null, array('label'=>"Société commerciale"))
            // ->add('siren')
            ->add('adresseNewTitulaire', AdresseType::class, array('label'=>"Adresse du nouveau titulaire "))
            // ->add('demande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewTitulaire::class,
        ]);
    }
}
