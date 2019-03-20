<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemarcheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeDemande')
            ->add('opposeDemande')
            ->add('statutDemande')
            ->add('paiementDemande')
            ->add('TmsIdDemande')
            ->add('progressionDemande')
            ->add('dateDemande')
            ->add('prix')
            ->add('nomfic')
            ->add('client', ClientType::class)
            ->add('Acquerreur')
            ->add('nomDemande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
