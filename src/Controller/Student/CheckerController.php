<?php

namespace App\Controller\Student;

use App\Entity\Checker;
use App\Repository\CheckerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class  CheckerController extends AbstractController
{
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

    return $this->render('student/checker/index.html.twig', [
      'checkers' => $checkers
    ]);
  }

  #[Route('/checker/{id}', name: 'checker.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Checker $checker): Response
  {
    return $this->render('student/checker/show.html.twig', compact('checker'));
  }
}
