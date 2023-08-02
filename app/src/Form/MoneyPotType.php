<?php

namespace App\Form;

use App\Entity\MoneyPot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoneyPotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('isShared')
//  wil be managed by controller, regarding MP of origin
//            ->add('transactions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MoneyPot::class,
        ]);
    }
}
