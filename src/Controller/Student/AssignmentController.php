<?php


namespace App\Controller\Student;

use App\Entity\Assignment;
use App\Mapped\MappedYear;
use App\Mapped\MappedSearch;
use App\Hydrate\HydrateAssignment;
use App\Form\FilterAssignmentFormType;
use App\Form\Other\MappedYearFormType;
use App\Form\Other\MappedSearchFormType;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class  AssignmentController extends AbstractController
{
  #[Route('/assignment', name: 'assignment.index', methods: ['GET'])]
  public function index(
    AssignmentRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $mapped = new MappedYear();

    $form = $this->createForm(MappedYearFormType::class, $mapped);
    $form->handleRequest($request);

    $assignments = $form->isSubmitted() && $form->isValid()
      ? $paginator->paginate(
        $repository->findSearchQuery($mapped)
      )
      : $paginator->paginate(
        $repository->findSearchQuery(),
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
