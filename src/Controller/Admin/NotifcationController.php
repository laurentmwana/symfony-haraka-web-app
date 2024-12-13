<?php


namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin', name: '~')]
class NotifcationController extends AbstractController
{
  public function __construct(
    private readonly NotificationRepository $notificationRepository,
  ) {}

  #[Route('/notification', name: 'notification.index', methods: ['GET'])]
  public function index(PaginatorInterface $paginator, Request $request): Response
  {
    $user = $this->getUser();

    if (!($user instanceof User)) {
      throw new \RuntimeException("L'utilisateur connecté devait avoir une instance de l'entité USER");
    }

    $builder = $this->notificationRepository->findSearchQuery(
      $user,
      $request->get('query'),
    );

    $notifications = $paginator->paginate(
      $builder,
      $request->get('page', 1)
    );

    return $this->render('admin/notification/index.html.twig', [
      'notifications' => $notifications
    ]);
  }

  public function show(Notification $notification): Response
  {
    return $this->render('admin/notification/show.html.twig', [
      'notification' => $notification
    ]);
  }
}
