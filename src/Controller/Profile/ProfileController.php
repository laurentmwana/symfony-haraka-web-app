<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Form\ProfileUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profile', name: 'profile.')]
class ProfileController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/checker', name: 'checker')]
  public function checker(Request $request, UserPasswordHasherInterface $hasher): Response
  {
    /** @var User */
    $user = $this->getUser();
    $form = $this->getForm($request, $user);
    if ($form->isSubmitted() && $form->isValid()) {

      $plainPassword  =  $form->get('password')->getData();
      if (null !== $plainPassword && !empty($plainPassword)) {
        $hashPassword = $hasher->hashPassword($user, $plainPassword);

        $user->setPassword($hashPassword);
      }

      $this->em->persist($user);
      $this->em->flush();
    }

    return $this->render('profile/checker.html.twig', [
      'form' => $form
    ]);
  }

  #[Route('/admin', name: 'admin')]
  public function admin(Request $request, UserPasswordHasherInterface $hasher): Response
  {
    /** @var User */
    $user = $this->getUser();
    $form = $this->getForm($request, $user);
    if ($form->isSubmitted() && $form->isValid()) {
      $plainPassword  =  $form->get('password')->getData();
      if (null !== $plainPassword && !empty($plainPassword)) {
        $hashPassword = $hasher->hashPassword($user, $plainPassword);

        $user->setPassword($hashPassword);
      }

      $this->em->persist($user);
      $this->em->flush();
    }

    return $this->render('profile/admin.html.twig', [
      'form' => $form
    ]);
  }

  #[Route('/student', name: 'student')]
  public function student(Request $request, UserPasswordHasherInterface $hasher): Response
  {
    /** @var User */

    $user = $this->getUser();
    $form = $this->getForm($request, $user);
    if ($form->isSubmitted() && $form->isValid()) {
      $plainPassword  =  $form->get('password')->getData();
      if (null !== $plainPassword && !empty($plainPassword)) {
        $hashPassword = $hasher->hashPassword($user, $plainPassword);

        $user->setPassword($hashPassword);
      }

      $this->em->persist($user);
      $this->em->flush();
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
