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
            ->add('contenu', TextareaType::class, ['label'=>'label.blog.comment'])
            ->add('auteur', TextType::class, ['label'=>'label.blog.auteurComment'])
            ->add('email', EmailType::class, ['label'=>'label.blog.email'])
            ->add('website', TextType::class, ['label'=>'label.blog.website', 'required'=>false ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
