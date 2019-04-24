<?php

namespace App\Form;

use App\Entity\Cotitulaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CotitulairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeCotitulaire', ChoiceType::class, array(
                'label' => "Personne (*)",
                'choices' => array(
                    'Personne Physique' => "phy",
                    'Personne Morale' => "mor",
                    )
                ))
            ->add('nomCotitulaires')
            ->add('prenomCotitulaire')
            ->add('raisonSocialCotitulaire')
            ->add('sexeCotitulaire', ChoiceType::class, array(
                'choices' => array(
                    'Homme' => "M",
                    'Femme' => "F",
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cotitulaires::class,
        ]);
    }
}
