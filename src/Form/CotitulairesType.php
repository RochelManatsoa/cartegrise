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
                    'Société' => "mor",
                    )
                ))
            ->add('nomCotitulaires', TextType::class, ['label'=>'label.nom.cotitulaire'])
            ->add('prenomCotitulaire', TextType::class, ['label'=>'label.prenom.cotitulaire'])
            ->add('raisonSocialCotitulaire', TextType::class, ['label'=>'label.raisonsocial'])
            ->add('sexeCotitulaire', ChoiceType::class, array(
                'choices' => array(
                    'Homme' => "M",
                    'Femme' => "F",
                    ) ,
                'label' =>'label.genre'
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
