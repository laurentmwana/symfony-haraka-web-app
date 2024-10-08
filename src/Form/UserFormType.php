<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Checker;
use App\Entity\Student;
use App\Enum\RoleEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Choice;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choice_label' => 'name',
                'choices' => RoleEnum::cases()
            ])
            ->add('password', PasswordType::class)
            ->add('username')
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'id',
                'mapped' => false
            ])
            ->add('checker', EntityType::class, [
                'class' => Checker::class,
                'choice_label' => 'id',
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
