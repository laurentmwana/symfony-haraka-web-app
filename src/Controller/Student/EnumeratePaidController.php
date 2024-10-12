<?php

namespace App\Controller\Student;

use App\Entity\Paid;
use App\Entity\User;
use App\Hydrate\HydratePaid;
use App\Hydrate\HydratePayment;
use App\Repository\PaidRepository;
use App\Form\FilterPaymentFormType;
use App\Repository\AmountRepository;
use App\Repository\PaymentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

#[Route('/enumerate', name: '#')]
class EnumeratePaidController extends AbstractController
{
    #[Route('/amount/{id}', name: 'enum.index')]
    #[IsGranted('PAID_VIEW', 'paid')]
    public function index(
        Paid $paid,
        PaymentRepository $paymentRepository,
        AmountRepository $amountRepository
    ): Response {

        $amount = $amountRepository->findAllForLevel($paid->getLevel());

        $payments = $paymentRepository->findAllForStudent(
            $amount,
            $paid->getStudent(),
            $paid->getLevel()
        );

        $hydrate = new HydratePaid();

        return $this->render('student/enumerate/index.html.twig', [
            'amount' => $amount,
            'payments' => $payments
        ]);
    }
}
