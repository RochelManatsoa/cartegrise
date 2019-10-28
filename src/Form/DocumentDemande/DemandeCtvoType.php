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
use App\Form\CustomType\FileType;
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
        ->add('pieceIdentite', FileType::class, [
            'label' => 'label.demande.pieceIdentiteValid',
            "required" => false,
            "data_class" => null,
        ])
        ->add('justificatifDomicile', FileType::class, [
            'label' => 'label.demande.justificatifDomicile',
            "required" => false,
            "data_class" => null,
        ])
        ->add('demandeCertificat', FileType::class, [
            'label' => 'label.demande.demandeCertificat',
            "required" => false,
            "data_class" => null,
        ])
        ->add('declatationCession', FileType::class, [
            'label' => 'label.demande.declatationCession',
            "required" => false,
            "data_class" => null,
        ])
        ->add('procurationMandat', FileType::class, [
            'label' => 'label.demande.procurationMandat',
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieControleTechnique', FileType::class, [
            'label' => 'label.demande.copieControleTechnique',
            "required" => false,
            "data_class" => null,
        ])
        ->add('recepisseDemandeAchat', FileType::class, [
            'label' => 'label.demande.recepisseDemandeAchat',
            "required" => false,
            "data_class" => null,
        ])
        ->add('copiePermisConduireTitulaire', FileType::class, [
            'label' => 'label.demande.copiePermisConduire',
            "required" => false,
            "data_class" => null,
        ])
        ->add('copieAttestationAssurance', FileType::class, [
            'label' => 'label.demande.copieAttestationAssuranceValide',
            "required" => false,
            "data_class" => null,
        ])
        ->add('rectoVersoCarteGrise', FileType::class, [
            'label' => 'label.demande.rectoVersoCarteGrise',
            "required" => false,
            "data_class" => null,
        ])
        ->add('save', SubmitType::class, ['label' => 'label.save'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeCtvo::class,
        ]);
    }
}