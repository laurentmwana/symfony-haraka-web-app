<?php

namespace App\Validator;

use App\Entity\Amount;
use App\Repository\InstallmentRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TotalPriceInstallmentValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var TotalPriceInstallment $constraint */

        if (!($value instanceof Amount)) {
            return;
        }

        $totalPrice = $value->getPrice();

        $collectInstaments =  $value->getInstallments();

        $totalItemsPrice = array_reduce(
            $collectInstaments->toArray(),
            fn($index, $item) => $index + $item->getPrice(),
            0
        );

        // Vérifier si la somme des prix des items est égale au prix total
        if ($totalItemsPrice !== $totalPrice) {
            // Construire le message d'erreur
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ totalItemsPrice }}', $totalItemsPrice)
                ->setParameter('{{ totalPrice }}', $totalPrice)
                ->atPath('installments.price')  // Appliquer l'erreur sur le champ des items
                ->addViolation();
        }
    }
}
