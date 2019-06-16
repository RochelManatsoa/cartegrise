<?php

namespace App\Form\Cession;

use App\Entity\UserInfos;
use Symfony\Component\Form\AbstractType;
use App\Form\AdresseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\{AncientitulaireType, NewtitulaireType};

class CessionVendeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    UserInfos::GENRE_FEMAL => UserInfos::GENRE_FEMAL,
                    UserInfos::GENRE_MALE => UserInfos::GENRE_MALE,
                ],
            ])
            ->add('particulierOrSociete', ChoiceType::class, [
                'choices' => [
                    UserInfos::USER_PARTICULAR => UserInfos::USER_PARTICULAR,
                    UserInfos::USER_SOCIETY => UserInfos::USER_SOCIETY,
                ],
            ])
            ->add('nom')
            ->add('prenom')
            ->add('nomUsage')
            ->add('phone')
            ->add('adresse', AdresseType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfos::class,
        ]);
    }
}
