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
            ->add('type', ChoiceType::class, array(
                'label' => 'label.type.personne',
                'choices' => array(
                    'Personne Physique' => "phy",
                    'Personne Morale' => "mor",
                ),
                'attr' => [
                    'class' => 'choice-type-newtitulaire'
                ]
            ))
            ->add('nomPrenomTitulaire', TextType::class, array(
                'label'=>'label.nomPrenomTitulaire',
                'required'=>false,
                ))
            ->add('prenomTitulaire', TextType::class, array(
                'label'=>'label.prenomTitulaire',
                'required'=>false,
                ))
            ->add('genre', ChoiceType::class, array(
                'label' => 'label.genre',
                'required'=>false,
                'choices' => array(
                    'Féminin' => "F",
                    'Masculin' => "M",
                ),
            ))
            ->add('dateN', DateType::class, array(
                'label'=>"label.dateN",
                'required'=>false,
                'widget' => 'single_text',
                ))
            ->add('lieuN', TextType::class, array(
                'required'=>false,
                'label'=> 'label.lieuN',
                ))
            // ->add('type')
            ->add('raisonSociale')
            ->add('societeCommerciale', null, array(
                'required'=>false,
                'label'=> 'label.societeCommerciale'
                ))
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
