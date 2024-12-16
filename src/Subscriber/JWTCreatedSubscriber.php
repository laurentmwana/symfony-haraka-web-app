<?php

namespace App\Subscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;


final class JWTCreatedSubscriber
{

  public function onJWTCreated(JWTCreatedEvent $event): void
  {
    $user = $event->getUser();

    if ($user instanceof User) {

      $payload = $event->getData();
      $payload['username'] = $user->getEmail();

      $event->setData($payload);
    }
  }

  /**
   * @return array<string, string>
   */
  public function getSubscribedEvents(): array
  {
    return [

      'lexik_jwt_authentication.on_jwt_created' => 'OnLexikJwtAuthenticationOnJwtCreated'
    ];
  }
}
