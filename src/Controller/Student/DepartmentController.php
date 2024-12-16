<?php


namespace App\Controller\Student;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student/edifice', name: '#')]
class DepartmentController extends AbstractController
{

  #[Route('/department', name: 'department.index', methods: ['GET'])]
  public function index(
    DepartmentRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $departments = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('student/department/index.html.twig', [
      'departments' => $departments
    ]);
  }

  #[Route('/department/{id}', name: 'department.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Department $department): Response
  {
    return $this->render('student/department/show.html.twig', compact('department'));
  }
}
