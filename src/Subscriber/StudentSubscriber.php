<?php

namespace App\Subscriber;

use App\Entity\Student;
use Doctrine\ORM\Events;
use App\Endroid\EndroidHandle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;

final class StudentSubscriber
{
  public function __construct(
    private EntityManagerInterface $em,
    private EndroidHandle $endroidHandle
  ) {}

  public function prePersist(PrePersistEventArgs $args): void
  {
    $student = $args->getObject();

    if ($student instanceof Student) {
      $file = $this->endroidHandle->write($student->getNumberPhone());

      $student->setIdentificator($file);

      $this->em->persist($student);
      $this->em->flush();
    }
  }


  /**
   * @return array<int, string>
   */
  public function getSubscribedEvents(): array
  {
    return [
      Events::prePersist,
    ];
  }
}
