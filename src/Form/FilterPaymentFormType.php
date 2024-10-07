<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\User;
use App\Helpers\Formatter;
use App\Entity\YearAcademic;
use App\Hydrate\HydratePayment;
use App\Repository\LevelRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FilterPaymentFormType extends AbstractType
{
    public function __construct(
        private LevelRepository $levelRepository,
        private Security $security
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User */
        $user = $this->security->getUser();

        $builder
            ->add('level', ChoiceType::class, [
                'choice_label' => fn(?Level $level): ?string => Formatter::levelWithStudent($level),
                'attr' => ['name' => 'level'],
                'placeholder' => 'Choisissez une promotion',
                'required' => false,
                'choices' => $this->levelRepository->findAllWithAllRelation($user->getStudent()->getId()),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HydratePayment::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
