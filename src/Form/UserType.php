<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder->add('client', ClientType::class)
                ->add('termsAccepted', CheckboxType::class, [
                    'mapped' => false,
                    'label' => "J'ai lu et j'accepte les Conditions Générales de Vente , notre politique de confidentialité et la liste des documents à retourner.",
                    'constraints' => new IsTrue(),
                ])
                ->add('debutImmediat', CheckboxType::class, [
                    'mapped' => false,
                    'label' => "Oui, je souhaite que ma demande de carte grise débute immédiatement. Ainsi je renonce expressément à mon droit de rétractation afin que la prestation débute avant la fin du délai légal de rétractation.",
                    'constraints' => new IsTrue(),
                ])
        ;
    }

    public function getParent()

    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()

    {
        return 'app_user_registration';
    }

    public function getName()

    {
        return $this->getBlockPrefix();
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
