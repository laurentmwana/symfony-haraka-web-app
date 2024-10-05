<?php

namespace App\Form;

use App\Entity\Checker;
use App\Entity\Faculty;
use App\Entity\Assignment;
use App\Helpers\Formatter;
use App\Entity\ExpenseControl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('faculty', EntityType::class, [
                'class' => Faculty::class,
                'choice_label' => 'name',
            ])
            ->add('expenseControl', EntityType::class, [
                'class' => ExpenseControl::class,
                'choice_label' => fn(?ExpenseControl $ec): ?string => Formatter::expenseControl($ec)
            ])
            ->add('checkers', EntityType::class, [
                'class' => Checker::class,
                'choice_label' => fn(?Checker $checker): ?string => Formatter::checker($checker),
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assignment::class,
        ]);
    }
}