<?php

namespace App\Form;

use App\Entity\Cession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\{AncientitulaireType, NewtitulaireType};

class CessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateCession', DateType::class, array(
                'label'=>"Date de cession (*)",
                'widget' => 'single_text',
                ))
            ->add('ancienTitulaire', AncientitulaireType::class)
            ->add('acquerreur', NewtitulaireType::class, array('label'=>"Nouveau titulaire"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cession::class,
        ]);
    }
}
