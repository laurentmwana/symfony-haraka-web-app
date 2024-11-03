<?php

namespace App\Subscriber;

use App\Entity\Paid;
use App\Entity\Level;
use App\Entity\Student;
use Doctrine\ORM\Events;
use App\Endroid\EndroidHandle;
use App\Helpers\TokenGenerator;
use App\Repository\PaidRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;

final class PaidSubscriber
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly PaidRepository $paidRepository
  ) {}

  public function onFlush(OnFlushEventArgs $args): void
  {

    $em = $args->getObjectManager();

    if (!($em instanceof EntityManagerInterface)) {
      return;
    }

    $uow = $em->getUnitOfWork();

    foreach ($uow->getScheduledCollectionUpdates() as $collection) {
      if (
        $collection instanceof PersistentCollection &&
        $collection->getOwner() instanceof Student &&
        $collection->getMapping()['fieldName'] === 'levels'
      ) {

        $student = $collection->getOwner();

        // add paid to student
        foreach ($collection->getInsertDiff() as $levelAdded) {
          if ($levelAdded instanceof Level) {
            $this->addPaid(
              $student,
              $levelAdded
            );
          }
        }

        // remove paid to student
        foreach ($collection->getDeleteDiff() as $levelRemoved) {
          if ($levelRemoved instanceof Level) {
            $this->removePaid($student, $levelRemoved);
          }
        }

        $uow->computeChangeSets();
      }
    }
  }


  /**
   * @return array<int, string>
   */
  public function getSubscribedEvents(): array
  {
    return [
      Events::onFlush,
      Events::postPersist,
    ];
  }

  private function addPaid(Student $student, Level $level): void
  {
    $file = EndroidHandle::write(TokenGenerator::alpha(80));

    $paid = (new Paid())
      ->setStudent($student)
      ->setLevel($level)
      ->setFile($file);

    $this->em->persist($paid);
  }

  private function removePaid(Student $student, Level $level): void
  {
    $paid = $this->paidRepository->findOneBy([
      'level' => $level,
      'student' => $student,
    ]);

    if ($paid instanceof Paid) {
      $this->em->remove($paid);
    }
  }
}
