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
use App\Entity\File\DemandeChangementAdresse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DemandeChangementAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('rectoVersoCarteGrise', FileType::class, [
            'label' => 'label.demande.copieRectoVersoCarteGrise',
            "required" => false,
            "data_class" => null,
        ])
        ->add('demandeCertificatImmatriculation', FileType::class, [
            'label' => 'label.demande.demandeCertificatImmatriculation',
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
        ->add('copiePermisConduire', FileType::class, [
            'label' => 'label.demande.copiePermisConduire',
            "required" => false,
            "data_class" => null,
        ])
        ->add('justificatifDomicile', FileType::class, [
            'label' => 'label.demande.justificatifDomicile',
            "required" => false,
            "data_class" => null,
        ])
        ->add('procurationMandat', FileType::class, [
            'label' => 'label.demande.procurationMandat',
            "required" => false,
            "data_class" => null,
        ])
        ->add('save', SubmitType::class, ['label' => 'label.save'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeChangementAdresse::class,
        ]);
    }
}