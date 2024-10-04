<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\Student;
use App\Enum\GenderEnum;
use App\Repository\LevelRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;

class StudentFormType extends AbstractType
{
    public function __construct(private LevelRepository $levelRepository) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('lastname')
            ->add('gender', ChoiceType::class, [
                'choice_label' => fn(?GenderEnum $enum): string|null => $enum?->name,
                'choice_value' => fn(?GenderEnum $enum): string|null => $enum?->value,
                'choices' => GenderEnum::cases(),
                'placeholder' => 'Choisissez le sexe'

            ])
            ->add('happy', null, [
                'widget' => 'single_text',
            ])
            ->add('number_phone')
            ->add('actualLevel', ChoiceType::class, [
                'choice_label' => fn(?Level $level): string|null => $this->formatLevel($level),
                'choice_value' => 'id',
                'choices' => $this->levelRepository->findAllWith(),
                'mapped' => false,
                'constraints' => [
                    new Validator\NotBlank(['groups' => ['student:validator:actual']]),
                    new Validator\Email(['groups' => ['student:validator:actual']]),
                ],
                'placeholder' => 'Choisissez une promotion'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }

    private  function formatLevel(?Level $level): ?string
    {
        return $level === null
            ? null
            : sprintf(
                "%s %s [%s]",
                $level->getProgramme()->getName(),
                $level->getSector()->getAlias(),
                $level->getYearAcademic()->getName()
            );
    }
}
