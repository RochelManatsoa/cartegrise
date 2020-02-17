<?php

namespace App\Form\Blog;

use App\Entity\Blog\{Article, Categorie};
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label'=>'label.blog.title'])
            ->add('contenu', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                ),
            ))
            ->add('description', TextareaType::class, ['label'=>'label.blog.description'])
            ->add('publication', ChoiceType::class, [
                'label' => 'label.blog.published', 
                'choices'=>[
                    'Oui'=>'true', 
                    'Non'=>'false'
                ]
            ])
            ->add('categories',EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'multiple'=>true,
                'expanded'=>true,
                'label' => 'label.blog.categories'
            ])
            ->add('ok', SubmitType::class, ['label' => 'label.blog.update'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
