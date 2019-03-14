<?php

namespace App\Form;

use App\Entity\Fichier;
use App\Entity\TypeDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', FileType::class, [
                'label'=>'Choisissez vos fichiers',
            ])
            ->add('type', HiddenType::class, [
                'class'=> TypeDemande::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fichier::class,
        ]);
    }
}
