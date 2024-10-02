<?php


namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class DepartmentController extends AbstractController
{
  #[Route('/department', name: 'department.index', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('admin/department/index.html.twig');
  }

  #[Route('/department/{id}', name: 'department.show', methods: ['GET'])]
  public function show(): Response
  {
    return $this->render('admin/department/show.html.twig');
  }

  #[Route('/department/{id}', name: 'department.edit', methods: ['GET', 'PUT'])]
  public function edit(): Response | RedirectResponse
  {
    return $this->render('admin/department/edit.html.twig');
  }

  #[Route('/department/create', name: 'department.edit', methods: ['GET', 'POST'])]
  public function create(): Response | RedirectResponse
  {
    return $this->render('admin/department/create.html.twig');
  }

  #[Route('/department/{id}', name: 'department.edit', methods: ['GET', 'DELETE'])]
  public function delete(): RedirectResponse
  {
    return $this->redirectToRoute('~department.index');
  }
}
