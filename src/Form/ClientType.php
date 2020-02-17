<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Validator\Constraints\IsTrue;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientNom', TextType::class,[
                'attr'  => array( 'class' => 'text-uppercase' ),
                'label' => 'label.nom.client'
            ])
            ->add('clientPrenom', TextType::class, ['label' => 'label.prenom.client'])
            ->add('clientGenre', ChoiceType::class, array(
                'choices'   => array(
                    'Homme' => "M",
                    'Femme' => "F",
                ),
                'label'=> 'label.genre',
            ))
            // ->add('clientDateNaissance', DateType::class, array(
            //         'widget' => 'single_text',
            //         'html5' => false,
            //         'label'  => 'label.dateN',
            //         'format' => 'dd/MM/yyyy',
            //         'attr' => ['class' => 'js-datepicker', 'placeholder' => 'dd/mm/yyyy'],
            //         ))            
            // ->add('clientLieuNaissance', TextType::class, ['label' => 'label.lieuN'])
            // ->add('clientDptNaissance', NumberType::class)
            // ->add('clientPaysNaissance', CountryType::class, array('label' => 'Pays','required'=> false, 'preferred_choices' => array('FR'=>'France')))            
            // ->add('clientAdresse', AdresseType::class, ['label' => 'label.clientAdresse']);
            ->add('clientContact', ContactType::class, ['label' => 'label.clientContact']);
            if ($options['label'] === "label.infoUser")
                $builder
                ->add('cgv', CheckboxType::class, [
                    'mapped' => false,
                    'label' => 'label.cgv',
                    'constraints' => new IsTrue(),
                ])
                // ->add('retractation', CheckboxType::class, [
                //     'mapped' => false,
                //     'label' => 'label.retractation',
                //     'constraints' => new IsTrue(),
                // ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}