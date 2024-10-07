<?php


namespace App\Controller\Checker;

use App\Entity\Assignment;
use App\Hydrate\HydrateAssignment;
use App\Form\FilterAssignmentFormType;
use App\Repository\AssignmentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/checker', name: '^')]
class  AssignmentController extends AbstractController
{
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

    return $this->render('student/assignment/index.html.twig', [
      'assignments' => $assignments,
      'form' => $form
    ]);
  }

  #[Route('/assignment/{id}', name: 'assignment.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Assignment $assignment): Response
  {
    return $this->render('student/assignment/show.html.twig', compact('assignment'));
  }
}
