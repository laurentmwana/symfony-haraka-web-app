<?php

namespace App\Form;

use App\Validator\TotalPriceInstallment;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\Amount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionInstallmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('installments', CollectionType::class, [
                'entry_type' => InstallmentFormType::class, // Formulaire pour un Installment
                'entry_options' => ['label' => false],
                'allow_add' => true, // Permet l'ajout dynamique de nouveaux champs
                'allow_delete' => true, // Permet la suppression des éléments
                'by_reference' => false, // Important pour que Symfony g
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Amount::class,
            'constraints' => new TotalPriceInstallment()
        ]);
    }
}
