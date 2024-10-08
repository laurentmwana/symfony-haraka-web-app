<?php


namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstallmentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class UserController extends AbstractController
{
  public function __construct(
    private EntityManagerInterface $em,
    private InstallmentRepository $installmentRepository,
  ) {}

  #[Route('/user', name: 'user.index', methods: ['GET'])]
  public function index(
    UserRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $users = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/user/index.html.twig', [
      'users' => $users
    ]);
  }

  #[Route('/user/{id}', name: 'user.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(User $user): Response
  {
    return $this->render('admin/user/show.html.twig', compact('amount'));
  }

  #[Route('/user/{id}/edit', name: 'user.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, User $user): Response|RedirectResponse
  {
    $form = $this->createForm(UserFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      return $this->redirectToRoute('~user.index');
    }

    return $this->render('admin/user/edit.html.twig', [
      'form' => $form,
      'user' => $user,
    ]);
  }

  #[Route('/user/create', name: 'user.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $user = new User();

    $form = $this->createForm(UserFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
    }

    return $this->render('admin/user/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/user/{id}/delete', name: 'user.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(User $user): RedirectResponse
  {
    $this->em->remove($user);
    $this->em->flush();

    return $this->redirectToRoute('~user.index');
  }
}
