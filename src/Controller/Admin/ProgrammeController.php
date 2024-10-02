<?php


namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class ProgrammeController extends AbstractController
{
  #[Route('/programme', name: 'programme.index', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('admin/programme/index.html.twig');
  }

  #[Route('/programme/{id}', name: 'programme.show', methods: ['GET'])]
  public function show(): Response
  {
    return $this->render('admin/programme/show.html.twig');
  }
}
