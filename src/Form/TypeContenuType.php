<?php

namespace App\Form;

use App\Entity\ContenuFichier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('carteGrise')
            ->add('demandImm')
            ->add('mandat')
            ->add('quitusFisc')
            ->add('certConformite')
            ->add('pieceIdentite')
            ->add('justifDomicile')
            ->add('pvControleTech')
            ->add('declarAchat')
            ->add('permisCond')
            ->add('attestAssur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContenuFichier::class,
        ]);
    }
}
