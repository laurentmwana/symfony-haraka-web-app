<?php


namespace App\Controller\Checker;

use App\Entity\User;
use App\Entity\Assignment;
use App\Mapped\MappedYear;
use App\Hydrate\HydrateAssignment;
use App\Form\FilterAssignmentFormType;
use App\Form\Other\MappedYearFormType;
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

    /**
     * @var User
     */
    $user = $this->getUser();

    $mapped = new MappedYear();

    $form = $this->createForm(MappedYearFormType::class, $mapped);
    $form->handleRequest($request);


    $assignments = $form->isSubmitted() && $form->isValid()
      ? $paginator->paginate(
        $repository->findSearchQueryForChecker($user->getChecker(), $mapped),
      )
      : $paginator->paginate(
        $repository->findSearchQueryForChecker($user->getChecker()),
      );

    return $this->render('checker/assignment/index.html.twig', [
      'assignments' => $assignments,
      'form' => $form
    ]);
  }

  #[Route('/assignment/{id}', name: 'assignment.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Assignment $assignment): Response
  {
    return $this->render('checker/assignment/show.html.twig', compact('assignment'));
  }
}
