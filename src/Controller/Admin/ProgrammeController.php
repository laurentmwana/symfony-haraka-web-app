<?php

namespace App\Controller\Admin;

use App\Entity\Programme;
use App\Repository\ProgrammeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class ProgrammeController extends AbstractController
{

  #[Route('/programme', name: 'programme.index', methods: ['GET'])]
  public function index(
    ProgrammeRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $programmes = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/programme/index.html.twig', [
      'programmes' => $programmes
    ]);
  }

  #[Route('/programme/{id}', name: 'programme.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Programme $programme): Response
  {
    return $this->render('admin/programme/show.html.twig', [
      'programme' => $programme
    ]);
  }
}
