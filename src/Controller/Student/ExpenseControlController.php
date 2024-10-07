<?php

namespace App\Controller\Student;

use App\Entity\ExpenseControl;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ExpenseControlRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class  ExpenseControlController extends AbstractController
{
  #[Route('/expense-control', name: 'expense-control.index', methods: ['GET'])]
  public function index(
    ExpenseControlRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $expenseControls = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('student/expense-control/index.html.twig', [
      'expenseControls' => $expenseControls
    ]);
  }

  #[Route('/expense-control/{id}', name: 'expense-control.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(ExpenseControl $expenseControl): Response
  {
    return $this->render('student/expense-control/show.html.twig', compact('expenseControl'));
  }
}
