<?php

namespace App\Form\Other;

use App\Mapped\MappedYear;
use App\Entity\YearAcademic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class MappedYearFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', SearchType::class, [
                'attr' => [
                    'name' => 'search',
                    'placeholder' => 'Recherche...',
                ],
                'required' => false,
            ])
            ->add('yearAcademic', EntityType::class, [
                'class' => YearAcademic::class,
                'choice_label' => 'name',
                'attr' => ['name' => 'year-academic'],
                'placeholder' => 'Choisissez une année academique',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MappedYear::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
