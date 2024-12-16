<?php

namespace App\Controller\Admin;

use App\Entity\Level;
use App\Entity\Programme;
use App\Mapped\MappedYear;
use App\Hydrate\HydrateLevel;
use App\Form\FilterLevelFormType;
use App\Repository\LevelRepository;
use App\Repository\ProgrammeRepository;
use App\Form\FilterLevelStudentFormType;
use App\Form\Other\MappedYearFormType;
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

    $mapped = new MappedYear();

    $form = $this->createForm(MappedYearFormType::class, $mapped);
    $form->handleRequest($request);

    $levels = $form->isSubmitted() && $form->isValid()
      ? $paginator->paginate(
        $repository->findSearchQuery($mapped),
        $request->get('page', 1)
      )

      : $paginator->paginate(
        $repository->findSearchQuery(),
        $request->get('page', 1)
      );

    return $this->render('admin/level/index.html.twig', [
      'levels' => $levels,
      'form' => $form
    ]);
  }


  #[Route('/level/{id}', name: 'level.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Level $level): Response
  {

    return $this->render('admin/level/show.html.twig', [
      'level' => $level,
    ]);
  }
}
