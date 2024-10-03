<?php

namespace App\Form;

use App\Entity\Sector;
use App\Entity\Programme;
use App\Entity\YearAcademic;
use App\Hydrate\HydrateLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterLevelFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('yearAcademic', EntityType::class, [
                'class' => YearAcademic::class,
                'choice_label' => 'name',
                'attr' => ['name' => 'year-academic'],
                'placeholder' => 'Choisissez une année academique',
                'required' => false,
            ])
            ->add('sector', EntityType::class, [
                'class' => Sector::class,
                'choice_label' => 'name',
                'attr' => ['name' => 'sector'],
                'placeholder' => 'Choisissez une option',
                'required' => false,
            ])
            ->add('programme', EntityType::class, [
                'class' => Programme::class,
                'choice_label' => 'name',
                'attr' => ['name' => 'programme'],
                'placeholder' => 'Choisissez une promotion',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HydrateLevel::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
