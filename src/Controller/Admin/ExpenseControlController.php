<?php


namespace App\Controller\Admin;

use App\Form\ExpenseControlFormType;
use App\Entity\ExpenseControl;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ExpenseControlRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class  ExpenseControlController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

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

    return $this->render('admin/expense-control/index.html.twig', [
      'expenseControls' => $expenseControls
    ]);
  }

  #[Route('/expense-control/{id}', name: 'expense-control.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(ExpenseControl $expenseControl): Response
  {
    return $this->render('admin/expense-control/show.html.twig', compact('expenseControl'));
  }

  #[Route('/expense-control/{id}/edit', name: 'expense-control.edit', methods: ['GET', 'POST'], requirements: ['id' => "[0-9]+"])]
  public function edit(Request $request, ExpenseControl $expenseControl): Response|RedirectResponse
  {
    $form = $this->createForm(ExpenseControlFormType::class, $expenseControl);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $expenseControl->setUpdatedAt(new \DateTime());

      $this->em->persist($expenseControl);
      $this->em->flush();

      return $this->redirectToRoute('~expense-control.index');
    }

    return $this->render('admin/expense-control/edit.html.twig', [
      'form' => $form,
      'expenseControl' => $expenseControl,
    ]);
  }

  #[Route('/expense-control/create', name: 'expense-control.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $expenseControl = new ExpenseControl();

    $form = $this->createForm(ExpenseControlFormType::class, $expenseControl);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($expenseControl);
      $this->em->flush();

      return $this->redirectToRoute('~expense-control.index');
    }

    return $this->render('admin/expense-control/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/expense-control/{id}/delete', name: 'expense-control.delete', methods: ['DELETE'], requirements: ['id' => "[0-9]+"])]
  public function delete(ExpenseControl $expenseControl): RedirectResponse
  {
    $this->em->remove($expenseControl);
    $this->em->flush();

    return $this->redirectToRoute('~expense-control.index');
  }
}
