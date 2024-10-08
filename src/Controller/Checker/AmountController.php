<?php


namespace App\Controller\Checker;

use App\Entity\Amount;
use App\Helpers\Number;
use App\Entity\Installment;
use App\Form\AmountFormType;
use App\Repository\AmountRepository;
use App\Repository\InstallmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/checker', name: '^')]
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

    return $this->render('checker/amount/index.html.twig', [
      'amounts' => $amounts
    ]);
  }

  #[Route('/amount/{id}', name: 'amount.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Amount $amount): Response
  {
    return $this->render('checker/amount/show.html.twig', compact('amount'));
  }
}
