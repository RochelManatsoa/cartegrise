<?php

namespace App\Form;

use App\Entity\Ctvo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\{AncientitulaireType, NewtitulaireType};

class CtvoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ancienTitulaire', AncientitulaireType::class)            
            ->add('acquerreur', NewtitulaireType::class, array('label'=>"Nouveau titulaire"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ctvo::class,
        ]);
    }
}
