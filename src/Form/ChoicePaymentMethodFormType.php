<?php

namespace App\Form;

use App\Entity\ChoiceMethodPayment;
use App\Entity\Faculty;
use App\Entity\PaymentMethod;
use App\Entity\YearAcademic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicePaymentMethodFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('paymentMethod', EntityType::class, [
                'class' => PaymentMethod::class,
                'choice_label' => 'name',
            ])
            ->add('yearAcademic', EntityType::class, [
                'class' => YearAcademic::class,
                'choice_label' => 'name',
            ])
            ->add('faculties', EntityType::class, [
                'class' => Faculty::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChoiceMethodPayment::class,
        ]);
    }
}
