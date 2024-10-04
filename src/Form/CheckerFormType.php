<?php

namespace App\Form;

use App\Entity\Checker;
use App\Enum\GenderEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CheckerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('gender', ChoiceType::class, [
                'choice_label' => fn(?GenderEnum $enum): string|null => $enum?->name,
                'choice_value' => fn(?GenderEnum $enum): string|null => $enum?->value,
                'choices' => GenderEnum::cases(),
                'placeholder' => 'Choisissez le sexe'

            ])
            ->add('number_phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Checker::class,
        ]);
    }
}
