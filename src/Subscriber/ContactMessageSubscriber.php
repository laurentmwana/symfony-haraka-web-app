<?php

namespace App\Subscriber;

use App\Entity\Paid;
use App\Entity\Level;
use App\Entity\Contact;
use App\Entity\Student;
use Doctrine\ORM\Events;
use App\Repository\PaidRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;

final class ContactMessageSubscriber
{
  public function postPersist(PostPersistEventArgs $args): void
  {
    $contact = $args->getObject();

    if ($contact instanceof Contact) {
      // envoyer l'email
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
