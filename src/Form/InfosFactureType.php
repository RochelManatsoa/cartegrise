<?php

namespace App\Form;

use App\Entity\InfosFacture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InfosFactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typePerson', ChoiceType::class, [
                'label' => ' ' ,
                'label_attr' => array('class' => 'type-person'),
                'choices'  => [
                    'label.person.type.physical' => false,
                    'label.person.type.corporation' => true,
                ],
                'expanded' => true,
                'required' => true,
                'data'     => 0
            ])
            ->add('socialReason', TextType::class,[
                'attr'  => array( 'class' => 'text-uppercase', 'placeholder' => "Nom de la société" ),
                'label' => 'label.socialReason.client',
                'required' => false,
            ])
            ->add('name', TextType::class,[
                'attr'  => array( 'class' => 'text-uppercase' ),
                'label' => 'label.nom.client',
                'required' => false,
            ])
            ->add('firstName', TextType::class,[
                'label' => 'label.prenom.client',
                'required' => false,
            ])
            ->add('adresse', AdresseType::class, [
                'label' => 'label.clientAdresse'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfosFacture::class,
        ]);
    }
}
