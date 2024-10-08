<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Entity\Checker;
use App\Entity\Student;
use App\Helpers\Formatter;
use App\Repository\CheckerRepository;
use App\Repository\StudentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Validator;

class ProfileUserFormType extends AbstractType
{
    public function __construct(private CheckerRepository $checkerRepository) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Validator\Optional(),
                    new Validator\Length(min: 6, max: 20),
                ]
            ])
            ->add('username')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
