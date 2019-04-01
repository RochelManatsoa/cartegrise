<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('numero', IntegerType::class, array('label' => 'Numero de Voie', 'required' => true))
            ->add('nom', TextType::class, array('label' => 'Nom de la Voie', 'required' => true))
            ->add('complement',  TextType::class, array('required' => false, 'attr' => array('placeholder' => 'Immeuble, Bâtiment, Résidence')))
            ->add('codepostal', TextType::class, array('label' => 'Code Postal', 'required' => true))
            ->add('ville', TextType::class, array('required' => true))
            //->add('pays', CountryType::class, array('label' => 'Pays','required'=> false, 'preferred_choices' => array('FR'=>'France')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
