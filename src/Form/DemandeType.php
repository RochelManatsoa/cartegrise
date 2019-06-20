<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeDemande')
            ->add('opposeDemande', null, ['label'=>'label.oppose'])
            ->add('statutDemande', null, ['label'=>'label.status'])
            ->add('paiementDemande', null, ['label'=>'label.paiement'])
            ->add('TmsIdDemande', null, ['label'=>'label.tms'])
            ->add('progressionDemande', null, ['label'=>'label.progression'])
            ->add('client')
            ->add('fichier', FichierType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
