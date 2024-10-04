<?php


namespace App\Controller\Admin;

use App\Entity\Checker;
use App\Entity\Department;
use App\Form\CheckerFormType;
use App\Form\DepartmentFormType;
use App\Repository\CheckerRepository;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class  CheckerController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/checker', name: 'checker.index', methods: ['GET'])]
  public function index(
    CheckerRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $checkers = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/checker/index.html.twig', [
      'checkers' => $checkers
    ]);
  }

  #[Route('/checker/{id}', name: 'checker.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Checker $checker): Response
  {
    return $this->render('admin/checker/show.html.twig', compact('checker'));
  }

  #[Route('/checker/{id}/edit', name: 'checker.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, Checker $checker): Response|RedirectResponse
  {
    $form = $this->createForm(CheckerFormType::class, $checker);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $checker->setUpdatedAt(new \DateTime());

      $this->em->persist($checker);
      $this->em->flush();

      return $this->redirectToRoute('~checker.index');
    }

    return $this->render('admin/checker/edit.html.twig', [
      'form' => $form,
      'checker' => $checker,
    ]);
  }

  #[Route('/checker/create', name: 'checker.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $checker = new Checker();

    $form = $this->createForm(CheckerFormType::class, $checker);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($checker);
      $this->em->flush();

      return $this->redirectToRoute('~checker.index');
    }

    return $this->render('admin/checker/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/checker/{id}/delete', name: 'checker.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(Checker $checker): RedirectResponse
  {
    $this->em->remove($checker);
    $this->em->flush();

    return $this->redirectToRoute('~checker.index');
  }
}
