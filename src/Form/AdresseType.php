<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typevoie', ChoiceType::class, [
                'choices'  => [
                    '...' => "SANS",
                    'Rue' => "RUE",
                    'Boulevard' => "BLVD",
                    'Avenue' => "AVN",
                    'Allée' => "ALL",
                    'Place' => "PLC",
                    'Impasse' => "IMP",
                    'Chemin' => "CHM",
                    'Quai' => "QUAI",
                    'Fort' => "FORT",
                    'Route' => "RTE",
                    'Passage' => "PASS",
                    'Cour' => "COUR",
                    'Chaussée' => "CHAU",
                    'Parc' => "PARC",
                    'Faubourg' => "FBG",
                    'Lieu-Dit' => "LDIT",
                    'Square' => "SQUA",
                    'Sente' => "SENT",
                ],
                'label' => 'label.typevoie',         
                ])
            ->add('numero', IntegerType::class, array(
                'label' => 'label.numero.voie',
                'constraints' => [
                    new NotBlank(['message'=>'Ce champs est requis'])
                ],
                'invalid_message_parameters' => ['%num%' => 2],
                ))
            ->add('nom', TextType::class, array('label' => 'label.nom.voie'))
            ->add('complement',  TextType::class, array(
                'required' => false, 
                'label'    => 'label.complement',
                'attr' => array(
                    'placeholder' => 'Lieu dit, numéro boîte aux lettres, nom de la résidence'
                    )
                ))
            ->add('codepostal', TextType::class, array('label' => 'label.codepostal'))
            ->add('ville', TextType::class, array('label' => 'label.ville'))
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
