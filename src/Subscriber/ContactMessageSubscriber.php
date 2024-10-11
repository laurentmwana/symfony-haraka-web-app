<?php

namespace App\Subscriber;

use App\Entity\Contact;
use Doctrine\ORM\Events;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


final class ContactMessageSubscriber
{
  public function __construct(private MailerInterface $mailer) {}

  public function postPersist(PostPersistEventArgs $args): void
  {
    $contact = $args->getObject();


    if ($contact instanceof Contact) {
      $email = (new TemplatedEmail())
        ->from(new Address('contactus@haraka.com', 'Haraka'))
        ->to((string) $contact->getEmail())
        ->subject('Nous contacter')
        ->htmlTemplate('emails/contact-us.html.twig')
        ->context([
          'contact' => $contact,
        ]);

      $this->mailer->send($email);
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
