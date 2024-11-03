<?php

namespace App\Controller\Student;

use App\Entity\Paid;
use App\Repository\AmountRepository;
use App\Repository\PaymentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Endroid\QrCode\Builder\BuilderInterface;


#[Route('/student/paids', name: '#')]
class EnumeratePaidController extends AbstractController
{
    public function __construct(BuilderInterface $customQrCodeBuilder)
    {
        $result = $customQrCodeBuilder
            ->size(400)
            ->margin(20)
            ->build();
    }

    #[Route('/enumerate/{id}', name: 'enum.index')]
    #[IsGranted('PAID_VIEW', 'paid')]
    public function index(
        Paid $paid,
        PaymentRepository $paymentRepository,
        AmountRepository $amountRepository
    ): Response {

        $amount = $amountRepository->findAllForLevel($paid->getLevel());

        $paidPayments = $paymentRepository->findSumBy(
            $amount,
            $paid->getStudent(),
            $paid->getLevel(),
            true
        );

        $unPaidPayments = $paymentRepository->findSumBy(
            $amount,
            $paid->getStudent(),
            $paid->getLevel()
        );

        $payments = $paymentRepository->findAllForStudent(
            $amount,
            $paid->getStudent(),
            $paid->getLevel()
        );


        return $this->render('student/enumerate/index.html.twig', [
            'amount' => $amount,
            'paid' => $paid,
            'payments' => $payments,
            'paidPayments' => $paidPayments,
            'unPaidPayments' => $unPaidPayments,
        ]);
    }
}
