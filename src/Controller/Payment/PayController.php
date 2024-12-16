<?php

namespace App\Controller\Payment;

use App\Entity\Paid;
use App\Entity\Level;
use App\Entity\Amount;
use App\Enum\PaidEnum;
use App\Entity\Payment;
use App\Entity\Student;
use App\Repository\PaidRepository;
use App\Repository\AmountRepository;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/pay', name: '@')]
class PayController extends AbstractController
{
  public function __construct(
    private AmountRepository $amountRepository,
    private PaymentRepository $paymentRepository,
    private PaidRepository $paidRepository,
    private EntityManagerInterface $em,
  ) {}

  #[Route('for-installment/payment/{id}', name: 'installment')]
  public function installment(Payment $payment): RedirectResponse
  {
    $paid = $this->getPaidEntity($payment->getStudent(), $payment->getLevel());
    $amount = $this->getAmountEntity($payment->getLevel());

    $pricePay = $this->calculateTotalPaid($amount, $payment->getStudent(), $payment->getLevel());
    $this->validateRemainingAmount($amount->getPrice(), $pricePay);

    $newPricePay = $pricePay + $payment->getInstallment()->getPrice();
    $this->updatePaymentState($paid, $newPricePay, $amount->getPrice());

    $payment->setPaid(true)->setPaymentAt(new \DateTime());

    $this->em->persist($payment);
    $this->em->flush();

    return $this->redirectToRoute('#enum.index', [
      'id' => $paid->getId()
    ]);
  }

  #[Route('for-totality/paid/{id}', name: 'totality')]
  public function totality(Paid $paid): RedirectResponse
  {
    $amount = $this->getAmountEntity($paid->getLevel());

    $pricePay = $this->calculateTotalPaid($amount, $paid->getStudent(), $paid->getLevel());
    $this->validateRemainingAmount($amount->getPrice(), $pricePay);

    $payments = $this->paymentRepository->findBy([
      'level' => $paid->getLevel(),
      'student' => $paid->getStudent(),
      'amount' => $amount,
    ]);

    foreach ($payments as $payment) {
      $payment->setPaid(true)->setPaymentAt(new \DateTime());
      $this->em->persist($payment);
    }

    $paid->setState(PaidEnum::TOTALITY);

    $this->em->persist($paid);

    $this->em->flush();

    return $this->redirectToRoute('#enum.index', [
      'id' => $paid->getId()
    ]);
  }

  private function calculateTotalPaid(Amount $amount, Student $student, Level $level): float
  {
    return $this->paymentRepository->findSumBy($amount, $student, $level);
  }

  private function getPaidEntity(Student $student, Level $level): Paid
  {
    $paid = $this->paidRepository->findOneBy([
      'student' => $student,
      'level' => $level,
    ]);

    if (!($paid instanceof Paid)) {
      throw new \RuntimeException("Problème lors de la récupération de l'état de paiement.");
    }

    return $paid;
  }

  private function getAmountEntity(Level $level): Amount
  {
    $amount = $this->amountRepository->findOneForLevel($level);

    if (!$amount instanceof Amount) {
      throw new \RuntimeException("Le montant pour ce niveau est introuvable.");
    }

    return $amount;
  }

  private function validateRemainingAmount(float $totalPrice, float $pricePaid): void
  {
    if ($totalPrice === $pricePaid) {
      throw new \RuntimeException("Vous êtes déjà en ordre avec le paiement.");
    }
  }

  private function updatePaymentState(Paid $paid, float $newPricePay, float $totalPrice): void
  {
    if ($newPricePay === $totalPrice) {
      $paid->setState(PaidEnum::TOTALITY);
    } else {
      $paid->setState(PaidEnum::PAID_NO_TOTALITY);
    }
  }
}
