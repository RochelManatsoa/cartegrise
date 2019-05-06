<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-29 10:13:32 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-29 16:24:54
 */
namespace App\Form\DocumentDemande;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\File\DemandeDuplicata;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DemandeDuplicataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('rectoVersoCarteGrise', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('declatationCession', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('demandeCertificat', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('procurationManda', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('pieceIdentite', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieControleTechnique', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('recepiseDemandeAchat', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieAttestationAssurance', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('copiePermisConduireTitulaire', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('justificatifDomicile', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeDuplicata::class,
        ]);
    }
}