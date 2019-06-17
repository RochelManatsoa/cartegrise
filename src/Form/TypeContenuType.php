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
            ->add('nom', null, ['label'=>'label.nom.content'])
            ->add('carteGrise', null, ['label'=>'label.type.content.carteGrise'])
            ->add('demandImm', null, ['label'=>'label.type.content.demandImm'])
            ->add('mandat', null, ['label'=>'label.type.content.mandat'])
            ->add('quitusFisc', null, ['label'=>'label.type.content.quitusFisc'])
            ->add('certConformite', null, ['label'=>'label.type.content.certConformite'])
            ->add('pieceIdentite', null, ['label'=>'label.type.content.pieceIdentite'])
            ->add('justifDomicile', null, ['label'=>'label.type.content.justifDomicile'])
            ->add('pvControleTech', null, ['label'=>'label.type.content.pvControleTech'])
            ->add('declarAchat', null, ['label'=>'label.type.content.declarAchat'])
            ->add('permisCond', null, ['label'=>'label.type.content.permisCond'])
            ->add('attestAssur', null, ['label'=>'label.type.content.attestAssur'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContenuFichier::class,
        ]);
    }
}
