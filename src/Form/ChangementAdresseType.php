<?php

namespace App\Form;

use App\Entity\ChangementAdresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\{AncientitulaireType, NewtitulaireType, AdresseType};

class ChangementAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nouveauxTitulaire', NewtitulaireType::class, array('label'=>'label.titulaire'))
            ->add('nouvelAdresse', AdresseType::class, array('label'=>'label.nouvelAdresse'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangementAdresse::class,
        ]);
    }
}
