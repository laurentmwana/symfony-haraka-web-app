<?php

namespace App\Controller\Student;

use App\Entity\Sector;
use App\Repository\SectorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student/edifice', name: '#')]
class SectorController extends AbstractController
{

  #[Route('/sector', name: 'sector.index', methods: ['GET'])]
  public function index(
    SectorRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $sectors = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('student/sector/index.html.twig', [
      'sectors' => $sectors
    ]);
  }

  #[Route('/sector/{id}', name: 'sector.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Sector $sector): Response
  {
    return $this->render('student/sector/show.html.twig', compact('sector'));
  }
}
