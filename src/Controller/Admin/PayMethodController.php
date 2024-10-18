<?php


namespace App\Controller\Admin;

use App\Form\PaymentMethodFormType;
use App\Entity\PaymentMethod;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstallmentRepository;
use App\Repository\PaymentMethodRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class PayMethodController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/pay-method', name: 'pay-method.index', methods: ['GET'])]
  public function index(
    PaymentMethodRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $paymentMethods = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/pay-method/index.html.twig', [
      'paymentMethods' => $paymentMethods
    ]);
  }

  #[Route('/pay-method/{id}', name: 'pay-method.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(PaymentMethod $paymentMethod): Response
  {
    return $this->render('admin/pay-method/show.html.twig', [
      'paymentMethod' => $paymentMethod
    ]);
  }

  #[Route('/pay-method/{id}/edit', name: 'pay-method.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, PaymentMethod $paymentMethod): Response|RedirectResponse
  {
    $form = $this->createForm(PaymentMethodFormType::class, $paymentMethod);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $paymentMethod->setUpdatedAt(new \DateTime());

      $this->em->persist($paymentMethod);
      $this->em->flush();

      return $this->redirectToRoute('~pay-method.index');
    }

    return $this->render('admin/pay-method/edit.html.twig', [
      'form' => $form,
      'paymentMethod' => $paymentMethod,
    ]);
  }

  #[Route('/pay-method/create', name: 'pay-method.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $paymentMethod = new PaymentMethod();

    $form = $this->createForm(PaymentMethodFormType::class, $paymentMethod);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->em->persist($paymentMethod);
      $this->em->flush();

      return $this->redirectToRoute('~pay-method.index');
    }

    return $this->render('admin/pay-method/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/pay-method/{id}/delete', name: 'pay-method.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(PaymentMethod $paymentMethod): RedirectResponse
  {
    $this->em->remove($paymentMethod);
    $this->em->flush();

    return $this->redirectToRoute('~pay-method.index');
  }
}
