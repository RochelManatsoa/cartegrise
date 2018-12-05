<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientNom', TextType::class)
            ->add('clientPrenom', TextType::class)
            ->add('clientGenre', ChoiceType::class, array(
                'choices' => array(
                    'Homme' => "M",
                    'Femme' => "F",
                ),
            ))
            ->add('clientNomUsage', TextType::class)
            ->add('clientDateNaissance', DateType::class, array(
                    'widget' => 'single_text',
                    ))
            ->add('clientLieuNaissance', TextType::class)
            ->add('clientDptNaissance', NumberType::class)
            ->add('clientPaysNaissance', TextType::class)
            ->add('clientContact', ContactType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}