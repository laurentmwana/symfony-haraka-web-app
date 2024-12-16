<?php

namespace App\Controller\Checker;

use App\Entity\User;
use App\Entity\ExpenseControl;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ExpenseControlRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/checker', name: '^')]
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

    return $this->render('checker/expense-control/index.html.twig', [
      'expenseControls' => $expenseControls
    ]);
  }

  #[Route('/expense-control/{id}', name: 'expense-control.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(ExpenseControl $expenseControl): Response
  {
    return $this->render('checker/expense-control/show.html.twig', compact('expenseControl'));
  }
}
