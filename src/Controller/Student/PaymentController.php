<?php

namespace App\Controller\Student;

use App\Hydrate\HydratePayment;
use App\Form\FilterPaymentFormType;
use App\Repository\PaymentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/student', name: '#')]
class PaymentController extends AbstractController
{
    #[Route('/payments', name: 'payment.index')]
    public function index(
        PaymentRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $hydrate = new HydratePayment();

        $form = $this->createForm(FilterPaymentFormType::class, $hydrate,);
        $form->handleRequest($request);

        $payments = $paginator->paginate(
            $repository->findSearchQuery($hydrate),
            $request->get('page', 1)
        );

        return $this->render('student/payment/index.html.twig', [
            'payments' => $payments,
            'form' => $form,
        ]);
    }
}
