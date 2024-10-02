<?php


namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class YearAcademicController extends AbstractController
{
  #[Route('/year-academic', name: 'year-academic.index', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('admin/year-academic/index.html.twig');
  }

  #[Route('/year-academic/{id}', name: 'year-academic.show', methods: ['GET'])]
  public function show(): Response
  {
    return $this->render('admin/year-academic/show.html.twig');
  }

  #[Route('/year-academic/{id}', name: 'year-academic.edit', methods: ['GET', 'PUT'])]
  public function closed(): Response | RedirectResponse
  {
    return $this->render('admin/year-academic/edit.html.twig');
  }
}
