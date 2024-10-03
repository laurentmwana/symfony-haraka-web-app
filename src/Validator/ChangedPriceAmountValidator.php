<?php

namespace App\Validator;

use App\Entity\Amount;
use App\Helpers\Number;
use App\Repository\InstallmentRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ChangedPriceAmountValidator extends ConstraintValidator
{
    public function __construct(private InstallmentRepository $repository) {}

    /**
     * @param Amount|null $value
     * @param ChangedPriceAmount $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var ChangedPriceAmount $constraint */

        if (!($value instanceof Amount)) {
            return;
        }

        $totalAmount = $this->repository->calculateTotalAmount($value);


        if ($value->getPrice() < $totalAmount) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string)$value->getPrice())
                ->atPath('price')
                ->addViolation();

            return;
        }

        $countInstallments = $this->repository->count(['amount' => $value]);

        if ($value->getMaxNumberInstallment() < $countInstallments) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string)$value->getPrice())
                ->atPath('max_number_installment')
                ->addViolation();

            return;
        }

        if (($value->getPrice() > $totalAmount) && ($value->getMaxNumberInstallment() === $countInstallments)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string)$value->getPrice())
                ->atPath('max_number_installment')
                ->addViolation();

            return;
        }

        if (($value->getPrice() === $totalAmount) && ($value->getMaxNumberInstallment() > $countInstallments)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string)$value->getPrice())
                ->atPath('price')
                ->addViolation();

            return;
        }


        $checkPriceArray = Number::divideIntoInstallments(
            $value->getPrice() - $totalAmount,
            $value->getMaxNumberInstallment() - $countInstallments
        );

        if (in_array($checkPriceArray, [0, -1])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string)$value->getPrice())
                ->atPath('price')
                ->addViolation();

            return;
        }
    }
}
