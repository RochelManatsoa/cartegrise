<?php

namespace App\Form;

use App\Entity\ContactUs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class ContactUsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label'=>'label.prenom.client'])
            ->add('name', TextType::class, ['label'=>'label.nom.client'])
            ->add('email', EmailType::class, ['label'=>'label.clientEmail'])
            // ->add('raison', ChoiceType::class, [
            //     'choices' => [
			// 			"Sales" => "Sales",
			// 			"Tech Support" => "Tech Support",
			// 			"General Feedback" => "General Feedback",
            //     ],
            //     'label'=>'label.raisonsocial',
            // ])
            ->add('description', TextareaType::class, ['label'=>'label.messages'])
            ->add('captcha', CaptchaType::class)
            ->add('submit', SubmitType::class, [
                'label'=>'label.send', 
                'attr' => ['class' => 'btn btn-blue']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactUs::class,
        ]);
    }
}
