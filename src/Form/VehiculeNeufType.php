<?php

namespace App\Form;

use App\Entity\Vehicule\VehiculeNeuf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeNeufType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'label' => 'label.vehicule.typeRecep',
                'choices' => array(
                    'Communautaire' => "com",
                    'Nationale' => "nat",
                ),
                'attr' => [
                    'class' => 'choice-type-reception'
                ]
            ))
            ->add('vin', TextType::class, [
                'label' => 'label.vehicule.vin',
                'required' => false,
                ])
            ->add('d1Marque', TextType::class, [
                'label' => 'label.vehicule.d1Marque',
                'required' => false,
                ])
            ->add('d2Version', TextType::class, [
                'label' => 'label.vehicule.d2Version',
                'required' => false,
                ])
            ->add('kNumRecepCe', TextType::class, [
                'label' => 'label.vehicule.kNumRecepCe',
                'required' => false,
                ])
            ->add('dateReception', DateType::class, array(
                'label'=>"label.vehicule.dateRecep",
                'widget' => 'single_text',
                'required' => false,
                ))
            ->add('d21Cenit', null, ['label' => 'label.vehicule.d21Cenit'])
            ->add('derivVp', ChoiceType::class, [
                'label' => 'label.vehicule.derivVp',
                'choices' => array(
                    'Oui' => "oui",
                    'Non' => "non",
                    )
                ])
            ->add('d3Denomination', null, ['label' => 'label.vehicule.d3Denomination'])
            ->add('f2MmaxTechAdm', null, ['label' => 'label.vehicule.f2MmaxTechAdm'])
            ->add('f2MmaxAdmServ', null, ['label' => 'label.vehicule.f2MmaxAdmServ'])
            ->add('f3MmaxAdmEns', null, ['label' => 'label.vehicule.f3MmaxAdmEns'])
            ->add('gMmaxAvecAttelage', null, ['label' => 'label.vehicule.gMmaxAvecAttelage'])
            ->add('g1PoidsVide', null, ['label' => 'label.vehicule.g1PoidsVide'])
            ->add('jCategorieCe', null, ['label' => 'label.vehicule.jCategorieCe'])
            ->add('j1Genre', null, ['label' => 'label.vehicule.j1Genre'])
            ->add('j2CarrosserieCe', null, ['label' => 'label.vehicule.j2CarrosserieCe'])
            ->add('j3Carrosserie', null, ['label' => 'label.vehicule.j3Carrosserie'])
            ->add('p1Cyl', null, ['label' => 'label.vehicule.p1Cyl'])
            ->add('p2PuissKw', null, ['label' => 'label.vehicule.p2PuissKw'])
            ->add('p3Energie', null, ['label' => 'label.vehicule.p3Energie'])
            ->add('p6PuissFiscale', null, ['label' => 'label.vehicule.p6PuissFiscale'])
            ->add('qRapportPuissMasse', null, ['label' => 'label.vehicule.qRapportPuissMasse'])
            ->add('s1NbPlaceAssise', null, ['label' => 'label.vehicule.s1NbPlaceAssise'])
            ->add('s2NbPlaceDebout', null, ['label' => 'label.vehicule.s2NbPlaceDebout'])
            ->add('u1NiveauSonore', null, ['label' => 'label.vehicule.u1NiveauSonore'])
            ->add('u2NbTours', null, ['label' => 'label.vehicule.u2NbTours'])
            ->add('v7Co2', null, ['label' => 'label.vehicule.v7Co2'])
            ->add('v9ClasseEnvCe', null, ['label' => 'label.vehicule.v9ClasseEnvCe'])
            ->add('z1Mention1', ChoiceType::class, [
                'label' => 'label.vehicule.z1Mention1',
                'choices' => array(
                    'Véhicule de démonstration' => "DEM",
                    'Véhicule en Transit Temporaire' => "TT",
                    )
                ])
            ->add('z1Value', DateType::class, array(
                'label'=>"label.vehicule.z1Value",
                'widget' => 'single_text',
                ))
            ->add('nbMentions', null, ['label' => 'label.vehicule.nbMentions'])
            //->add('divn')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VehiculeNeuf::class,
        ]);
    }
}
