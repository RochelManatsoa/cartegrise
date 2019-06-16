<?php

namespace App\Form;

use App\Entity\Cession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\{AncientitulaireType, NewtitulaireType};
use App\Form\Cession\{CessionVendeurType, CessionAcheteurType};

class CessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateHeureDeLaVente', DateTimeType::class,[
                'date_label' => 'Date de la vente *',
                'time_label' => 'Heure de la vente *',
                'label_attr' => [
                    'style' => 'font-size: 12px',
                ],
                'years' => range(1990,2019),
            ])
            ->add('numeroDeLaFormulCarteGrise', TextType::class, array())
            ->add('vendeur', CessionVendeurType::class, array())
            ->add('acheteur', CessionAcheteurType::class, array())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cession::class,
        ]);
    }
}
