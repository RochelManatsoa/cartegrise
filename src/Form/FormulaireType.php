<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\TypeDemande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DivnInitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class FormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('demarche', EntityType::class, array(
               'class' => TypeDemande::class,
               'choice_label' => 'nom',
               'attr' => array(
                   'class' => 'choice-type-demarche'
               )
                ))
            ->add('codePostal', ChoiceType::class, [
                'label' => 'label.dep',
                'choices' => $options['departement']
                ])
            ->add('immatriculation', null, [
                'label' => 'label.immatriculation',
                'required' => true,
                ]);
            if (isset($options['hasCaptcha']) && $options['hasCaptcha']) {
                $builder->add('captcha', CaptchaType::class);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'hasCaptcha' => false
        ]);

        $resolver->setRequired(array('departement'));
    }
}
