<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\Amount;
use App\Entity\Programme;
use App\Entity\YearAcademic;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AmountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $handleFilter = function (EntityRepository $er): QueryBuilder {
            return $er->createQueryBuilder('y')
                ->where('y.closed = :closed')
                ->setParameter('closed', false);
        };

        $builder
            ->add('price')
            ->add('max_number_installment')
            ->add('programme', EntityType::class, [
                'class' => Programme::class,
                'choice_label' => 'name',
            ])
            ->add('yearAcademic', EntityType::class, [
                'class' => YearAcademic::class,
                'choice_label' => 'name',
                'query_builder' => $handleFilter
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Amount::class,
        ]);
    }
}
