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
            ->add('type', ChoiceType::class, [
                'label' => 'label.type.personne',
                'choices' => [
                    'Personne Physique' => "phy",
                    'Société' => "mor",
                ],
                'required' => false,
                'attr' => [
                    'class' => 'choice-type-personne'
                ]
            ])
            ->add('nomPrenomTitulaire', TextType::class, array(
                'label'=>'label.nom.titulaire',
                'required' => false
                ))
            ->add('prenomTitulaire', TextType::class, array(
                'label'=>'label.prenom.titulaire',
                'required' => false
                ))
            ->add('genre', ChoiceType::class, array(
                'label' => 'label.genre',
                'choices' => array(
                    'Féminin' => "F",
                    'Masculin' => "M",
                ),
                'required' => false
            ))
            ->add('dateN', DateType::class, array(
                'label'=>"label.dateN",
                'widget' => 'single_text',
                'required' => false
                ))
            ->add('lieuN', TextType::class, [
                'label'=> 'label.lieuN',
                'required' => false
                ])
            // ->add('type')
            ->add('raisonSociale', TextType::class, array(
                'label'=>'label.raisonsocial',
                'required' => false
                ))
            ->add('societeCommerciale', null, [
                'label'=> 'label.societeCommerciale',
                'required' => false
            ])
            ->add('siren')
            ->add('droitOpposition')
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
