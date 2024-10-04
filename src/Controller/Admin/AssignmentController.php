<?php


namespace App\Controller\Admin;

use App\Entity\Assignment;
use App\Form\AssignmentFormType;
use App\Hydrate\HydrateAssignment;
use App\Form\FilterAssignmentFormType;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class  AssignmentController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/assignment', name: 'assignment.index', methods: ['GET'])]
  public function index(
    AssignmentRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $hydrate = new HydrateAssignment();

    $form = $this->createForm(FilterAssignmentFormType::class, $hydrate);
    $form->handleRequest($request);

    $assignments = $paginator->paginate(
      $repository->findSearchQuery($hydrate),
      $request->get('page', 1)
    );

    return $this->render('admin/assignment/index.html.twig', [
      'assignments' => $assignments,
      'form' => $form
    ]);
  }

  #[Route('/assignment/{id}', name: 'assignment.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Assignment $assignment): Response
  {
    return $this->render('admin/assignment/show.html.twig', compact('assignment'));
  }

  #[Route('/assignment/{id}/edit', name: 'assignment.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, Assignment $assignment): Response|RedirectResponse
  {
    $form = $this->createForm(AssignmentFormType::class, $assignment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $assignment->setUpdatedAt(new \DateTime());

      $this->em->persist($assignment);
      $this->em->flush();

      return $this->redirectToRoute('~assignment.index');
    }

    return $this->render('admin/assignment/edit.html.twig', [
      'form' => $form,
      'assignment' => $assignment,
    ]);
  }

  #[Route('/assignment/create', name: 'assignment.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $assignment = new Assignment();

    $form = $this->createForm(AssignmentFormType::class, $assignment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($assignment);
      $this->em->flush();

      return $this->redirectToRoute('~assignment.index');
    }

    return $this->render('admin/assignment/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/assignment/{id}/delete', name: 'assignment.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(Assignment $assignment): RedirectResponse
  {
    $this->em->remove($assignment);
    $this->em->flush();

    return $this->redirectToRoute('~assignment.index');
  }
}
