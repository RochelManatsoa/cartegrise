<?php

namespace App\Form;

use App\Entity\Documents;
use App\Entity\Fichier;
use App\Entity\Demande;
use App\Entity\TypeFichier;
use App\Repository\DemandeRepository;
use App\Repository\TypeFichierRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichierType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('type', EntityType::class, array(
               'class' => Documents::class,
               'label' => 'Type de fichier:',
               'choice_label' => 'nom',
               'data'=>$options['defaultType'],
           ))
           ->add('demande', EntityType::class, array(
               'class' => Demande::class,
               'label' => 'Type de demande:',
               'choice_label' => 'typeDemande',
               'data'=>$options['defaultDemande']
           ))
            ->add('url', FileType::class, [
                'label'=>'Choisissez vos fichiers',
            ])
            ->add('save', SubmitType::class, array(
                    'label' => 'Envoyer',
                    'attr' => array(
                        'class'=>'btn btn-info btn-lg'
                    )
                )
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fichier::class,
        ]);

        $resolver->setRequired(array('defaultType','defaultDemande'));
    }
}