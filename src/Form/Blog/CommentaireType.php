<?php

namespace App\Form\Blog;

use App\Entity\Blog\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('contenu', TextareaType::class, ['label'=>'label.comment'])
        ->add('auteur', TextType::class, ['label'=>'label.auteurComment'])
        ->add('email', EmailType::class, ['label'=>'label.email'])
        ->add('website', TextType::class, ['label'=>'label.website', 'required'=>false ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
