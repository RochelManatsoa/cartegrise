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
            ->add('nomPrenomTitulaire', TextType::class, array(
                'label'=>'label.nomPrenomTitulaire'
                ))
            ->add('prenomTitulaire', TextType::class, array('label'=>"Prénom(s) de l’acquéreur (*)"))
            ->add('genre', ChoiceType::class, array(
                'label' => 'label.genre',
                'choices' => array(
                    'Féminin' => "F",
                    'Masculin' => "M",
                ),
            ))
            ->add('dateN', DateType::class, array(
                'label'=>"label.dateN",
                'widget' => 'single_text',
                ))
            ->add('lieuN', TextType::class, array('label'=> 'label.lieuN'))
            // ->add('type')
            ->add('raisonSociale')
            ->add('societeCommerciale', null, array('label'=> 'label.societeCommerciale'))
            // ->add('siren')
            ->add('adresseNewTitulaire', AdresseType::class, array('label'=>'label.adresseNewTitulaire'))
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
