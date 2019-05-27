<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-04-29 10:13:32 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-27 12:42:01
 */
namespace App\Form\DocumentDemande;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\File\DemandeCtvo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DemandeCtvoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('rectoVersoCarteGrise', FileType::class, [
            "required" => false,
            "data_class" => null,
        ])
        ->add('declatationCession', FileType::class, [
            "label" => "Déclaration de cession => Cerfa 15776*01",
            "required" => false,
            "data_class" => null,
        ])
        ->add('demandeCertificat', FileType::class, [
            "label" => "Demande de certificat => Cerfa 13750*05",
            "required" => false,
            "data_class" => null,
        ])
        ->add('procurationMandat', FileType::class, [
            "label" => "Mandat d'immatriculation",
            "required" => false,
            "data_class" => null,
        ])
        ->add('pieceIdentite', FileType::class, [
            "label" => "Pièce d'identité",
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieControleTechnique', FileType::class, [
            "label" => "Copie du controle technique",
            "required" => false,
            "data_class" => null,
        ])
        ->add('recepisseDemandeAchat', FileType::class, [
            "label" => "Récépissé de la demande d'achat",
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieAttestationAssurance', FileType::class, [
            "label" => "Copie de l'attestation assurance",
            "required" => false,
            "data_class" => null,
        ])
        ->add('copiePermisConduireTitulaire', FileType::class, [
            "label" => "Copie du permis de conduire titulaire",
            "required" => false,
            "data_class" => null,
        ])
        ->add('justificatifDomicile', FileType::class, [
            "label" => "Justificatif de domicile",
            "required" => false,
            "data_class" => null,
        ])
        ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeCtvo::class,
        ]);
    }
}