<?php


namespace App\Controller\Admin;

use App\Entity\Amount;
use App\Helpers\Number;
use App\Entity\Installment;
use App\Form\AmountFormType;
use App\Form\CollectionInstallmentFormType;
use App\Form\InstallmentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class InstallmentController extends AbstractController
{
  public function __construct(
    private EntityManagerInterface $em
  ) {}

  #[Route('/amount/{id}/generate-manual', name: 'installment.manual', methods: ['GET', 'POST'], requirements: ['id' => "[0-9]+"])]
  public function manual(Request $request, Amount $amount): Response|RedirectResponse
  {
    $form = $this->createForm(CollectionInstallmentFormType::class, $amount);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($amount);
      $this->em->flush();

      return $this->redirectToRoute('~amount.index');
    }

    return $this->render('admin/installment/manual.html.twig', [
      'form' => $form,
      'amount' => $amount,
    ]);
  }
}
