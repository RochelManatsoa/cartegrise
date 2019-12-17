<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr'  => array( 'class' => 'text-uppercase' ),
                'label' => 'label.nom.client'
            ])
            ->add('firstName', TextType::class,[
                'label' => 'label.prenom.client'
            ])
            ->add('label', IntegerType::class,[
                'label' => 'label.label'
            ])
            ->add('adresse', AdresseType::class, [
                'label' => 'label.clientAdresse'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
