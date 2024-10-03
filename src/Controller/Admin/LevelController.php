<?php

namespace App\Controller\Admin;

use App\Entity\Level;
use App\Entity\Programme;
use App\Form\FilterLevelFormType;
use App\Hydrate\HydrateLevel;
use App\Repository\LevelRepository;
use App\Repository\ProgrammeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class LevelController extends AbstractController
{

  #[Route('/level', name: 'level.index', methods: ['GET'])]
  public function index(
    LevelRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $hydrate = new HydrateLevel();

    $form = $this->createForm(FilterLevelFormType::class, $hydrate);
    $form->handleRequest($request);

    $levels = $paginator->paginate(
      $repository->findSearchQuery($hydrate),
      $request->get('page', 1)
    );

    return $this->render('admin/level/index.html.twig', [
      'levels' => $levels,
      'form' => $form
    ]);
  }

  #[Route('/level/{id}', name: 'level.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Level $level): Response
  {
    return $this->render('admin/level/show.html.twig', [
      'level' => $level
    ]);
  }
}
