<?php

namespace App\Subscriber;

use App\Entity\Paid;
use App\Entity\Amount;
use App\Entity\Payment;
use Doctrine\ORM\Events;
use App\Repository\AmountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;

final class PaymentSubscriber
{

  private bool $isFlush = false;


  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly AmountRepository $amountRepository
  ) {}

  public function postPersist(PostPersistEventArgs $args): void
  {
    $paid = $args->getObject();

    if (!($paid instanceof Paid)) {
      return;
    }


    // Vérifier si un flush est déjà en cours pour éviter la boucle infinie
    if ($this->isFlush) {
      return;
    }

    $this->isFlush = true; // Marquer le début du flush

    $student = $paid->getStudent();
    $level = $paid->getLevel();

    $amount = $this->amountRepository->findOneForLevel(
      $level
    );

    if (!($amount instanceof Amount)) {
      return;
    }

    foreach ($amount->getInstallments() as $installment) {
      $payment = (new Payment())
        ->setLevel($level)
        ->setStudent($student)
        ->setInstallment($installment)
        ->setAmount($amount);

      $this->em->persist($payment);
    }
    $this->em->flush();

    $this->isFlush = false;
  }

  /**
   * @return array<int, string>
   */
  public function getSubscribedEvents(): array
  {
    return [
      Events::postPersist,
    ];
  }
}
