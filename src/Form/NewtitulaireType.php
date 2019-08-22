<?php

namespace App\Form;

use App\Entity\NewTitulaire;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewtitulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'label' => 'label.type.personne',
                'choices' => array(
                    'Physique' => "phy",
                    'Société' => "mor",
                ),
                'attr' => array(
                    'class' => 'choice-type-personne'
                )
                ))
            ->add('nomPrenomTitulaire', TextType::class, array(
                'label'=>$options['label'] === "label.dca.titulaire" ? 'label.nom.dcaNomPrenom' : 'label.nom.titulaire',
                'required' => false
                ))
            ->add('prenomTitulaire', TextType::class, array(
                'label'=>'label.prenom.client',
                'required' => false
                ))
            ->add('genre', ChoiceType::class, array(
                'label' => 'label.genre',
                'choices' => array(
                    'Féminin' => "F",
                    'Masculin' => "M",
                ),
            ))
            ->add('dateN', DateType::class, array(
                'label'=>"label.dateN",
                'required' => false,
                'widget' => 'single_text',
                ))
            ->add('lieuN', TextType::class, array(
                'label'=> 'label.lieuN',
                'required' => false,
                ))
            ->add('raisonSociale')
            ->add('societeCommerciale', null, array('label'=> 'label.societeCommerciale'))
            ->add('siren')
            ->add('droitOpposition', null, array('label'=> 'label.droitOpposition'))
            ->add('adresseNewTitulaire', AdresseType::class, [
                    'label'=> $options['label'] === "label.dca.titulaire" ? 'label.nouvelAdresse' : 'label.adresseNewTitulaire',
                ]);
            if ($options['label'] === "label.dca.titulaire")
                $builder
                    ->add('birthName', TextType::class, array(
                        'label'=>'label.nom.dcaBirthName',
                        'required' => false,
                    ))
                    ->add('departementN', ChoiceType::class, [
                        'label' => 'label.ctvo.departementN',
                        'choices' => array_merge(["Aucun" => null], (new Commande())->DEPARTMENTS),
                    ])
                    ->add('paysN', TextType::class, array(
                        'label'=>'label.ctvo.paysN',
                        'required' => false,
                        'attr' => ['value' => "France"]
                    ));
            if ($options['label'] === "label.ctvo.titulaire")
                $builder
                    ->add('departementN', ChoiceType::class, [
                        'label' => 'label.ctvo.departementN',
                        'choices' => array_merge(["Aucun" => null], (new Commande())->DEPARTMENTS),
                    ])
                    ->add('paysN', TextType::class, array(
                        'label'=>'label.ctvo.paysN',
                        'required' => false,
                        'attr' => ['value' => "France"]
                    ))
            // ->add('demande')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewTitulaire::class,
        ]);
    }
}