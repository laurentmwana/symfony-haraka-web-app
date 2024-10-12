<?php


namespace App\Controller\Admin;

use App\Entity\ChoiceMethodPayment;
use App\Form\ChoicePaymentMethodFormType;
use App\Entity\PaymentMethod;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstallmentRepository;
use App\Repository\ChoiceMethodPaymentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class ChoicePayMethodController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/choice-pay-method', name: 'choice-pay-method.index', methods: ['GET'])]
  public function index(
    ChoiceMethodPaymentRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $choicePaymentMethods = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/choice-pay-method/index.html.twig', [
      'choicePaymentMethods' => $choicePaymentMethods
    ]);
  }

  #[Route('/choice-pay-method/{id}', name: 'choice-pay-method.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(ChoiceMethodPayment $choiceMethodPayment): Response
  {
    return $this->render('admin/choice-pay-method/show.html.twig', [
      'choiceMethodPayment' => $choiceMethodPayment
    ]);
  }

  #[Route('/choice-pay-method/{id}/edit', name: 'choice-pay-method.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, ChoiceMethodPayment $choiceMethodPayment): Response|RedirectResponse
  {
    $form = $this->createForm(ChoicePaymentMethodFormType::class, $choiceMethodPayment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $choiceMethodPayment->setUpdatedAt(new \DateTime());

      $this->em->persist($choiceMethodPayment);
      $this->em->flush();

      return $this->redirectToRoute('~choice-pay-method.index');
    }

    return $this->render('admin/choice-pay-method/edit.html.twig', [
      'form' => $form,
      'choiceMethodPayment' => $choiceMethodPayment,
    ]);
  }

  #[Route('/choice-pay-method/create', name: 'choice-pay-method.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $choiceMethodPayment = new ChoiceMethodPayment();

    $form = $this->createForm(ChoicePaymentMethodFormType::class, $choiceMethodPayment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->em->persist($choiceMethodPayment);
      $this->em->flush();

      return $this->redirectToRoute('~choice-pay-method.index');
    }

    return $this->render('admin/choice-pay-method/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/choice-pay-method/{id}/delete', name: 'choice-pay-method.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(ChoiceMethodPayment $choiceMethodPayment): RedirectResponse
  {
    $this->em->remove($choiceMethodPayment);
    $this->em->flush();

    return $this->redirectToRoute('~choice-pay-method.index');
  }
}
