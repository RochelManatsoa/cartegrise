<?php

namespace App\Form;

use App\Entity\NewTitulaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewtitulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomPrenomTitulaire')
            ->add('genre')
            ->add('dateN',DateType::class, array(
                'widget' => 'single_text',
                ))
            ->add('lieuN')
            ->add('type')
            ->add('raisonSociale')
            ->add('societeCommerciale')
            ->add('siren')
            ->add('adresseNewTitulaire', AdresseNewTitulaireType::class)
            ->add('demande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewTitulaire::class,
        ]);
    }
}
