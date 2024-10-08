<?php


namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Form\UserStudentFormType;
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
class UserStudentController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/student', name: 'user.student.index', methods: ['GET'])]
  public function index(
    UserRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $users = $paginator->paginate(
      $repository->findSearchForStudentQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/user/student/index.html.twig', [
      'users' => $users
    ]);
  }

  #[Route('/student/{id}', name: 'user.student.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(User $user): Response
  {
    return $this->render('admin/user/student/show.html.twig', compact('user'));
  }

  #[Route('/student/{id}/edit', name: 'user.student.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, User $user, UserPasswordHasherInterface $hasher): Response|RedirectResponse
  {
    $form = $this->createForm(UserStudentFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $plainPassword  =  $form->get('password')->getData();
      if (null !== $plainPassword && !empty($plainPassword)) {
        $hashPassword = $hasher->hashPassword($user, $plainPassword);

        $user->setPassword($hashPassword);
      }

      $user->setRoles([RoleEnum::ROLE_STUDENT->value]);

      $this->em->persist($user);
      $this->em->flush();


      return $this->redirectToRoute('~user.student.index');
    }

    return $this->render('admin/user/student/edit.html.twig', [
      'form' => $form,
      'user' => $user,
    ]);
  }
  #[Route('/student/create', name: 'user.student.create', methods: ['GET', 'POST'])]
  public function create(Request $request, UserPasswordHasherInterface $hasher): Response|RedirectResponse
  {
    $user = new User();

    $form = $this->createForm(UserStudentFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $hashPassword = $hasher->hashPassword($user, $form->get('password')->getData());

      $user->setPassword($hashPassword);
      $user->setRoles([RoleEnum::ROLE_STUDENT->value]);

      $this->em->persist($user);
      $this->em->flush();
    }

    return $this->render('admin/user/student/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/student/{id}/delete', name: 'user.student.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(User $user): RedirectResponse
  {
    $this->em->remove($user);
    $this->em->flush();

    return $this->redirectToRoute('~user.student.index');
  }
}
