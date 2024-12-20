<?php

namespace App\Controller\Student;

use App\Entity\User;
use App\Hydrate\HydratePayment;
use App\Repository\PaidRepository;
use App\Form\FilterPaymentFormType;
use App\Form\Other\MappedYearFormType;
use App\Mapped\MappedYear;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class PaidController extends AbstractController
{
    #[Route('/paids', name: 'paid.index')]
    public function index(
        PaidRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        /** @var User */
        $user = $this->getUser();

        $mapped = new MappedYear();

        $form = $this->createForm(MappedYearFormType::class, $mapped,);
        $form->handleRequest($request);

        $paids = $paginator->paginate(
            $repository->findAllPaids($user->getStudent()),
            $request->get('page', 1)
        );

        return $this->render('student/paid/index.html.twig', [
            'paids' => $paids,
            'form' => $form,
        ]);
    }
}
