<?php


namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Form\UserCheckerFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/user', name: '~')]
class UserCheckerController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/checker', name: 'user.checker.index', methods: ['GET'])]
  public function index(
    UserRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $users = $paginator->paginate(
      $repository->findSearchForCheckerQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/user/checker/index.html.twig', [
      'users' => $users
    ]);
  }

  #[Route('/checker/{id}', name: 'user.checker.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(User $user): Response
  {
    return $this->render('admin/user/checker/show.html.twig', compact('user'));
  }

  #[Route('/checker/{id}/edit', name: 'user.checker.edit', methods: ['GET', 'POST'], requirements: ['id' => "[0-9]+"])]
  public function edit(Request $request, User $user, UserPasswordHasherInterface $hasher): Response|RedirectResponse
  {
    $form = $this->createForm(UserCheckerFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $plainPassword  =  $form->get('password')->getData();
      if (null !== $plainPassword && !empty($plainPassword)) {
        $hashPassword = $hasher->hashPassword($user, $plainPassword);

        $user->setPassword($hashPassword);
      }
      $user->setUpdatedAt(new \DateTime());
      $user->setRoles([RoleEnum::ROLE_CHECKER->value]);

      $this->em->persist($user);
      $this->em->flush();

      return $this->redirectToRoute('~user.checker.index');
    }

    return $this->render('admin/user/checker/edit.html.twig', [
      'form' => $form,
      'user' => $user,
    ]);
  }

  #[Route('/checker/create', name: 'user.checker.create', methods: ['GET', 'POST'])]
  public function create(Request $request, UserPasswordHasherInterface $hasher): Response|RedirectResponse
  {
    $user = new User();

    $form = $this->createForm(UserCheckerFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $hashPassword = $hasher->hashPassword($user, $form->get('password')->getData());
      $user->setPassword($hashPassword);
      $user->setRoles([RoleEnum::ROLE_CHECKER->value]);

      $this->em->persist($user);
      $this->em->flush();

      return $this->redirectToRoute('~user.checker.index');
    }

    return $this->render('admin/user/checker/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/checker/{id}/delete', name: 'user.checker.delete', methods: ['DELETE'], requirements: ['id' => "[0-9]+"])]
  public function delete(User $user): RedirectResponse
  {
    $this->em->remove($user);
    $this->em->flush();

    return $this->redirectToRoute('~user.checker.index');
  }
}
