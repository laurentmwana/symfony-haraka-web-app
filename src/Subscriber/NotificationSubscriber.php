<?php

namespace App\Subscriber;

use App\Entity\Payment;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostUpdateEventArgs;

final class NotificationSubscriber
{

  public function postUpdate(PostUpdateEventArgs $args): void
  {
    $object = $args->getObject();

    if ($object instanceof Payment) {
    }
  }

  /**
   * @return array<int, string>
   */
  public function getSubscribedEvents(): array
  {
    return [
      Events::postUpdate,
    ];
  }
}
