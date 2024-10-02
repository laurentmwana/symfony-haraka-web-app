<?php


namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class SectorController extends AbstractController
{
  #[Route('/sector', name: 'sector.index', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('admin/sector/index.html.twig');
  }

  #[Route('/sector/{id}', name: 'sector.show', methods: ['GET'])]
  public function show(): Response
  {
    return $this->render('admin/sector/show.html.twig');
  }

  #[Route('/sector/{id}', name: 'sector.edit', methods: ['GET', 'PUT'])]
  public function edit(): Response | RedirectResponse
  {
    return $this->render('admin/sector/edit.html.twig');
  }

  #[Route('/sector/create', name: 'sector.edit', methods: ['GET', 'POST'])]
  public function create(): Response | RedirectResponse
  {
    return $this->render('admin/sector/create.html.twig');
  }

  #[Route('/sector/{id}', name: 'sector.edit', methods: ['GET', 'DELETE'])]
  public function delete(): RedirectResponse
  {
    return $this->redirectToRoute('~sector.index');
  }
}
