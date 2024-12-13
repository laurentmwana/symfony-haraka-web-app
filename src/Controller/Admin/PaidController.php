<?php

namespace App\Controller\Admin;

use App\Entity\Paid;
use App\Mapped\MappedYear;
use App\Repository\PaidRepository;
use App\Form\Other\MappedYearFormType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class PaidController extends AbstractController
{

  #[Route('/paid', name: 'paid.index', methods: ['GET'])]
  public function index(
    PaidRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $mapped = new MappedYear();

    $form = $this->createForm(MappedYearFormType::class, $mapped);
    $form->handleRequest($request);

    $paids = $form->isSubmitted() && $form->isValid()
      ? $paginator->paginate(
        $repository->findSearchQuery($mapped),
        $request->get('page', 1)
      )

      : $paginator->paginate(
        $repository->findSearchQuery(),
        $request->get('page', 1)
      );

    return $this->render('admin/paid/index.html.twig', [
      'paids' => $paids,
      'form' => $form
    ]);
  }


  #[Route('/paid/{id}', name: 'paid.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Paid $paid): Response
  {

    return $this->render('admin/paid/show.html.twig', [
      'paid' => $paid,
    ]);
  }
}
