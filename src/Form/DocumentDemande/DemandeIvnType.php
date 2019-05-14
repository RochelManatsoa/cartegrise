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
use App\Entity\File\DemandeIvn;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DemandeIvnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('originalCertificatConformiteEuropeen', FileType::class, [
            "label" => "Original du certificat de conformité europeen",
            "required" => false,
            "data_class" => null,
        ])
        ->add('certificatVenteOriginalFactureAchat', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('pieceIdentiteValid', FileType::class, [
            "label" => "Piece d'identité valide",  
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieAttestationAssuranceValide', FileType::class, [
            "label" => "Copie d'attestation d'assurance valide",
            "required" => false,
            "data_class" => null,
        ])
        ->add('copiePermisConduireTitulaire', FileType::class, [
            "label" => "Copie du permis de conduire du titulaire",
            "required" => false,
            "data_class" => null,
        ])
        ->add('demandeOriginalCertificatImmatriculation', FileType::class, [
            "label" => "Demande original du certificat d'immatriculation",
            "required" => false,
            "data_class" => null,
        ])
        ->add('procurationParMandat', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('justificatifDomicileRecent', FileType::class, [
            "label" => "Justificatif de domicile recent",
            "required" => false,
            "data_class" => null,
        ])
        ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeIvn::class,
        ]);
    }
}