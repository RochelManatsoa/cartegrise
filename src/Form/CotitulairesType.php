<?php

namespace App\Form;

use App\Entity\Cotitulaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CotitulairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeCotitulaire', ChoiceType::class, array(
                'label' => 'label.type.personne',
                'choices' => array(
                    'Personne Physique' => "phy",
                    'Personne Morale' => "mor",
                ),
                'attr' => [
                    'class' => 'choice-type-ancientitulaire'
                ]
                ))
            ->add('nomCotitulaires', TextType::class, [
                'label'=> 'label.nom.cotitulaire',
                'required' => false,
                ])
            ->add('prenomCotitulaire', TextType::class, [
                'label'=> 'label.prenom.cotitulaire',
                'required' => false,
                ])
            ->add('raisonSocialCotitulaire', TextType::class, [
                'label'=> 'label.raisonsocial',
                'required' => false,
                ])
            ->add('sexeCotitulaire', ChoiceType::class, array(
                'label' => 'label.genre',
                'choices' => array(
                    'Féminin' => "F",
                    'Masculin' => "M",
                    ),
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cotitulaires::class,
        ]);
    }
}
