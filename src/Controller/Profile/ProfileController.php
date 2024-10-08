<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Form\ProfileUserFormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'profile.')]
class ProfileController extends AbstractController
{
  #[Route('/checker', name: 'checker')]
  public function checker(Request $request): Response
  {
    $user = $this->getUser();
    $form = $this->getForm($request, $user);
    if ($form->isSubmitted() && $form->isValid()) {
    }

    return $this->render('profile/checker.html.twig', [
      'form' => $form
    ]);
  }

  #[Route('/admin', name: 'admin')]
  public function admin(Request $request): Response
  {
    $user = $this->getUser();
    $form = $this->getForm($request, $user);
    if ($form->isSubmitted() && $form->isValid()) {
    }

    return $this->render('profile/admin.html.twig', [
      'form' => $form
    ]);
  }

  #[Route('/student', name: 'student')]
  public function student(Request $request): Response
  {
    $user = $this->getUser();
    $form = $this->getForm($request, $user);
    if ($form->isSubmitted() && $form->isValid()) {
    }

    return $this->render('profile/student.html.twig', [
      'form' => $form
    ]);
  }

  private function getForm(Request $request, User $user): FormInterface
  {
    $form = $this->createForm(ProfileUserFormType::class, $user);
    $form->handleRequest($request);

    return $form;
  }
}
