<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile', name: 'profile.')]
class ProfileController extends AbstractController
{
  #[Route('/checker', name: 'checker')]
  public function checker(): Response
  {
    return $this->render('profile/checker.html.twig');
  }

  #[Route('/admin', name: 'admin')]
  public function admin(): Response
  {
    return $this->render('profile/admin.html.twig');
  }

  #[Route('/student', name: 'student')]
  public function student(): Response
  {
    return $this->render('profile/student.html.twig');
  }
}
