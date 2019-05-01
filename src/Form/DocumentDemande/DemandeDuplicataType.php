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

class DemandeDuplicataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('rectoVersoCarteGrise', FileType::class)
        ->add('declatationCession', FileType::class)
        ->add('demandeCertificat', FileType::class)
        ->add('procurationManda', FileType::class)
        ->add('pieceIdentite', FileType::class)
        ->add('copieControleTechnique', FileType::class)
        ->add('recepiseDemandeAchat', FileType::class)
        ->add('copieAttestationAssurance', FileType::class)
        ->add('copiePermisConduireTitulaire', FileType::class)
        ->add('justificatifDomicile', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeDuplicata::class,
        ]);
    }
}