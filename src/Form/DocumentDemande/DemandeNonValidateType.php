<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-10 09:59:36 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-10 10:28:21
 */
namespace App\Form\DocumentDemande;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Demande;

class DemandeNonValidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add("motifDeRejet", CKEditorType::class, array(
            'config' => array(
                'uiColor' => '#ffffff',
            ),
            'label' => 'label.motifDeRejet'
        ))
        ->add('Enregistrer', SubmitType::class, [
            'label'=>'label.save',
            'attr'=>[
                'class'=>'btn-validate-command d-flex align-items-center justify-content-between btn btn-blue btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }

}