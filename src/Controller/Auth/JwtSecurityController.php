<?php

namespace App\Controller\Auth;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: "api/auth", name: '*')]
class JwtSecurityController extends AbstractController
{
  #[Route(path: "/login", name: 'me')]
  public function login(): Response
  {
    /** @var User */
    $user = $this->getUser();

    return $this->json([
      'username' => $user->getUserIdentifier(),
      'roles' => $user->getRoles(),
    ]);
  }

  #[Route(path: 'logout', name: 'logout')]
  public function logout(): void
  {
    throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
  }
}
