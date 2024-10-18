<?php

namespace App\Subscriber;

use App\Entity\Identificator;
use App\Entity\Student;
use Doctrine\ORM\Events;
use App\Endroid\EndroidHandle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;

final class StudentSubscriber
{
  public function __construct(
    private EntityManagerInterface $em,
    private EndroidHandle $endroidHandle
  ) {}

  public function postPersist(PostPersistEventArgs $args): void
  {
    $student = $args->getObject();
    if ($student instanceof Student) {
      $file = $this->endroidHandle->write($student->getNumberPhone());

      $identificator = (new Identificator())
        ->setFile($file)
        ->setStudent($student);

      $this->em->persist($identificator);
      $this->em->flush();
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
}
