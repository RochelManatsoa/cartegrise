<?php

namespace App\Form\Registration;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder
        //     ->add('password', PasswordType::class, array(
        //         'label' => 'label.oldPassword', 
        //         ))
        //     ->add('plainPassword', PasswordType::class, array(
        //         'label' => 'form.password', 
        //         'required' => false
        //         ))
            // ->add('plainPassword', RepeatedType::class, array(
            //     'type' => PasswordType::class,
            //     'options' => array(
            //         'attr' => array(
            //             'autocomplete' => 'new-password',
            //         ),
            //     ),
            //     'first_options' => array('label' => 'label.newPassword'),
            //     'second_options' => array('label' => 'label.newPassword_confirmation'),
            //     'invalid_message' => 'fos_user.password.mismatch',
            // ))
        // ;
        $builder
            ->add('password', PasswordType::class, array(
                'label' => 'label.oldPassword', 
                'mapped' => false
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => 'label.newPassword'),
                'second_options' => array('label' => 'label.newPassword_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
                'required' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_token_id' => 'registration',
        ]);
    }
}