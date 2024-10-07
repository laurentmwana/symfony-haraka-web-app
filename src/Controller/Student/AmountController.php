<?php


namespace App\Controller\Student;

use App\Entity\Amount;
use App\Repository\AmountRepository;
use App\Repository\InstallmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class AmountController extends AbstractController
{
  #[Route('/amount', name: 'amount.index', methods: ['GET'])]
  public function index(
    AmountRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $amounts = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('student/amount/index.html.twig', [
      'amounts' => $amounts
    ]);
  }

  #[Route('/amount/{id}', name: 'amount.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Amount $amount): Response
  {
    return $this->render('student/amount/show.html.twig', compact('amount'));
  }
}
