<?php

namespace App\Controller\Student;

use App\Entity\Faculty;
use App\Repository\FacultyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student/edifice', name: '#')]
class FacultyController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/faculty', name: 'faculty.index', methods: ['GET'])]
  public function index(
    FacultyRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $faculties = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('student/faculty/index.html.twig', [
      'faculties' => $faculties
    ]);
  }

  #[Route('/faculty/{id}', name: 'faculty.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Faculty $faculty): Response
  {
    return $this->render('student/faculty/show.html.twig', compact('faculty'));
  }
}
