<?php


namespace App\Controller\Admin;

use App\Entity\Amount;
use App\Helpers\Number;
use App\Entity\Installment;
use App\Helpers\RegexConst;
use App\Form\AmountFormType;
use App\Repository\AmountRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstallmentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin', name: '~')]
class AmountController extends AbstractController
{
  public function __construct(
    private EntityManagerInterface $em,
    private InstallmentRepository $installmentRepository,
  ) {}

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

    return $this->render('admin/amount/index.html.twig', [
      'amounts' => $amounts
    ]);
  }

  #[Route('/amount/{id}', name: 'amount.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Amount $amount): Response
  {
    return $this->render('admin/amount/show.html.twig', compact('amount'));
  }

  #[Route('/amount/{id}/edit', name: 'amount.edit', methods: ['GET', 'POST'], requirements: ['id' => "[0-9]+"])]
  public function edit(Request $request, Amount $amount): Response|RedirectResponse
  {
    $form = $this->createForm(AmountFormType::class, $amount);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $amount->setUpdatedAt(new \DateTime());

      $totalAmount = $this->installmentRepository->calculateTotalAmount($amount);
      $countInstallments = $this->installmentRepository->count(['amount' => $amount]);

      $this->generateEdit(
        $amount,
        $amount->getPrice() - $totalAmount,
        $amount->getMaxNumberInstallment() - $countInstallments,
        $countInstallments + 1
      );

      return $this->redirectToRoute('~amount.index');
    }

    return $this->render('admin/amount/edit.html.twig', [
      'form' => $form,
      'amount' => $amount,
    ]);
  }

  #[Route('/amount/create', name: 'amount.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $amount = new Amount();

    $form = $this->createForm(AmountFormType::class, $amount);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->generatePost($amount);

      return $amount->isGenerate()
        ? $this->redirectToRoute('~amount.index')
        : $this->redirectToRoute('~installment.manual', [
          'id' => $amount->getId(),
        ]);
    }

    return $this->render('admin/amount/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/amount/{id}/delete', name: 'amount.delete', methods: ['DELETE'], requirements: ['id' => "[0-9]+"])]
  public function delete(Amount $amount): RedirectResponse
  {
    $this->em->remove($amount);
    $this->em->flush();

    return $this->redirectToRoute('~amount.index');
  }

  private function generatePost(Amount $amount): void
  {
    $installments = Number::divideIntoInstallments(
      $amount->getPrice(),
      $amount->getMaxNumberInstallment()
    );

    foreach ($installments as $index => $price) {
      $installment = (new Installment())
        ->setAmount($amount)
        ->setPrice($price)
        ->setPriority($index + 1);

      $amount->addInstallment($installment);
    }


    $this->em->persist($amount);
    $this->em->flush();
  }


  private function generateEdit(
    Amount $amount,
    float $totalPrice,
    int $number,
    int $startIndex
  ): void {
    $installments = Number::divideIntoInstallments(
      $totalPrice,
      $number
    );

    $index = $startIndex;
    foreach ($installments as $price) {
      $installment = (new Installment())
        ->setAmount($amount)
        ->setPrice($price)
        ->setPriority($index);

      $amount->addInstallment($installment);

      $index++;
    }


    $this->em->persist($amount);
    $this->em->flush();
  }
}
