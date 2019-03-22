<?php

namespace App\Form;

use App\Entity\AdresseNewTitulaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressNewTitulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroRue', TextType::class, array('label' => 'Numéro de la rue (*)'))
            ->add('extension', TextType::class, array('label' => 'Extension (*)'))
            ->add('adprecision', TextType::class, array('label' => 'Précision sur l’étage, l’appartement, l’escalier, le bâtiment, …', 'required'=>false))
            ->add('typevoie', ChoiceType::class, array(
                'label' => 'Type de la voie (*)',
                'choices' => array(
                    'Rue' => "rue",
                    'Boulevard' => "boul",
                    'Allée' => "all",
                    'Place' => "plc",
                    'Impasse' => "imp",
                    'Chemin' => "chm",
                    'Quai' => "qai",
                    'Fort' => "frt",
                    'Route' => "rte",
                    'Passage' => "psg",
                    'Chaussé' => "chs",
                    'Cour' => "cou",
                    'Parc' => "prc",
                    'Faubourg' => "fbg",
                    'Square' => "sqr",
                    'Sente' => "sen",
                    'Inconnu' => "...",
                ),
                ))
            ->add('nomvoie', TextType::class, array('label' => 'Nom de la voie (*)'))
            ->add('complement', TextType::class, array('label' => 'Complément ', 'required'=>false))
            ->add('lieudit', TextType::class, array('label' => 'Lieu dit', 'required'=>false))
            ->add('codepostal', TextType::class, array('label' => 'Code postale (*)'))
            ->add('ville', TextType::class, array('label' => 'Ville (*)'))
            ->add('boitepostal', TextType::class, array('label' => 'Boîte postale', 'required'=>false))
            ->add('pays', CountryType::class, array('label' => 'Pays','required'=> false, 'preferred_choices' => array('FR'=>'France')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdresseNewTitulaire::class,
        ]);
    }
}
