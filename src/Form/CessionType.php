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
                'label'=> 'label.dateCession',
                'widget' => 'single_text',
                ))
            ->add('ancienTitulaire', AncientitulaireType::class, array('label'=>'label.ancienTitulaire'))
            ->add('acquerreur', NewtitulaireType::class, array('label'=>'label.acquerreur'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cession::class,
        ]);
    }
}
