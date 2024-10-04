<?php

namespace App\Form;

use App\Entity\ExpenseControl;
use App\Entity\YearAcademic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseControlFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_at', null, [
                'widget' => 'single_text',
            ])
            ->add('end_at', null, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('yearAcademics', EntityType::class, [
                'class' => YearAcademic::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExpenseControl::class,
        ]);
    }
}
