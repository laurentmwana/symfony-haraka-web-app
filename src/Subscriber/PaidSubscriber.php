<?php

namespace App\Subscriber;

use App\Entity\Paid;
use App\Entity\Level;
use App\Entity\Amount;
use App\Entity\Payment;
use App\Entity\Student;
use Doctrine\ORM\Events;
use App\Endroid\EndroidHandle;
use App\Helpers\TokenGenerator;
use App\Repository\PaidRepository;
use App\Repository\AmountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;

final class PaidSubscriber
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly PaidRepository $paidRepository,
    private readonly AmountRepository $amountRepository,
  ) {}


  public function postPersist(PostPersistEventArgs $args): void
  {
    $student = $args->getObject();
    if ($student instanceof Student) {
      $this->addPaid(
        $student,
        $student->getLevel(),
      );
    }
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

  private function addPaid(Student $student, Level $level): void
  {
    $token = TokenGenerator::alpha(255);

    $file = EndroidHandle::write($token);

    $paid = (new Paid())
      ->setStudent($student)
      ->setFile($file)
      ->setToken($token)
      ->setLevel($level);

    $this->em->persist($paid);

    $this->addInitPayment($student, $level);


    $this->em->flush();
  }

  private function addInitPayment(
    Student $student,
    Level $level
  ): void {
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
  }
}
