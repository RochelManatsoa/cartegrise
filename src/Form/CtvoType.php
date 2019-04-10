<?php

namespace App\Form;

use App\Entity\Ctvo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\{AncientitulaireType, NewtitulaireType};
use App\Form\CotitulairesType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CtvoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ancienTitulaire', AncientitulaireType::class)            
            ->add('acquerreur', NewtitulaireType::class, array('label'=>"Nouveau titulaire"))
            ->add('cotitulaire', CollectionType::class, [
                'entry_type' => CotitulairesType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ctvo::class,
        ]);
    }
}
