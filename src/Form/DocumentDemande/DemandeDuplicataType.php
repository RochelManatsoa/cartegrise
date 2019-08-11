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
        ->add('justificatifDomicile', FileType::class, [
            'label' => 'label.demande.justificatifDomicile',
            "required" => false,
            "data_class" => null,
        ])
        ->add('certificatImmatriculation', FileType::class, [
            'label' => 'label.demande.certificatImmatriculation',
            "required" => false,
            "data_class" => null,
        ])
        ->add('declarationdePerteOuVol', FileType::class, [
            'label' => 'label.demande.declarationdePerteOuVol',
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieControleTechniqueEnCoursValidite', FileType::class, [
            'label' => 'label.demande.copieControleTechniqueEnCoursValidite',
            "required" => false,
            "data_class" => null,
        ])
        ->add('pieceIdentiteValid', FileType::class, [
            'label' => 'label.demande.pieceIdentiteValid',
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieAttestationAssuranceValide', FileType::class, [
            'label' => 'label.demande.copieAttestationAssuranceValide',
            "required" => false,
            "data_class" => null,
        ])
        ->add('permisDeConduireDuTitulaire', FileType::class, [
            'label' => 'label.demande.copiePermisConduire',
            "required" => false,
            "data_class" => null,
        ])
        ->add('cerfaDeclarationPerteVol', FileType::class, [
            'label' => 'label.demande.cerfaDeclarationdePerteOuVol',
            "required" => false,
            "data_class" => null,
        ])
        ->add('save', SubmitType::class, ['label' => 'label.save'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeDuplicata::class,
        ]);
    }
}