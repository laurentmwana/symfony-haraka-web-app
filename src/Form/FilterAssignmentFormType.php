<?php

namespace App\Form;

use App\Entity\Checker;
use App\Entity\Faculty;
use App\Entity\YearAcademic;
use App\Entity\ExpenseControl;
use App\Hydrate\HydrateAssignment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterAssignmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('expenseControl', EntityType::class, [
                'class' => ExpenseControl::class,
                'choice_label' => fn(?ExpenseControl $expenseControl) => $this->formatExpenseControl($expenseControl),
                'attr' => ['name' => 'expense-control'],
                'placeholder' => 'Choisissez un',
                'required' => false,
            ])
            ->add('yearAcademic', EntityType::class, [
                'class' => YearAcademic::class,
                'choice_label' => 'name',
                'attr' => ['name' => 'year-academic'],
                'placeholder' => 'Choisissez une année academique',
                'required' => false,
            ])
            ->add('query', null, [
                'attr' => ['name' => 'query'],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HydrateAssignment::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    private function formatExpenseControl(?ExpenseControl $expenseControl): ?string
    {
        return $expenseControl === null
            ? null
            : sprintf(
                "%s - %s",
                $expenseControl->getStartAt()->format('d-m-Y'),
                $expenseControl->getEndAt()->format('d-m-Y'),
            );
    }
}
