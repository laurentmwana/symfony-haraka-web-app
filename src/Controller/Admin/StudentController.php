<?php


namespace App\Controller\Admin;

use App\Entity\Student;
use App\Form\StudentFormType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class StudentController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/student', name: 'student.index', methods: ['GET'])]
  public function index(
    StudentRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $students = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/student/index.html.twig', [
      'students' => $students
    ]);
  }

  #[Route('/student/{id}', name: 'student.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Student $student): Response
  {
    return $this->render('admin/student/show.html.twig', compact('student'));
  }

  #[Route('/student/{id}/edit', name: 'student.edit', methods: ['GET', 'POST'], requirements: ['id' => "[0-9]+"])]
  public function edit(Request $request, Student $student): Response|RedirectResponse
  {
    $form = $this->createForm(StudentFormType::class, $student);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $student->setUpdatedAt(new \DateTime());

      $this->em->flush();

      return $this->redirectToRoute('~student.index');
    }


    return $this->render('admin/student/edit.html.twig', [
      'form' => $form,
      'student' => $student,
    ]);
  }

  #[Route('/student/create', name: 'student.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $student = new Student();

    $form = $this->createForm(StudentFormType::class, $student);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->em->persist($student);
      $this->em->flush();

      return $this->redirectToRoute('~student.index');
    }

    return $this->render('admin/student/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/student/{id}/delete', name: 'student.delete', methods: ['DELETE'], requirements: ['id' => "[0-9]+"])]
  public function delete(Student $student): RedirectResponse
  {
    $this->em->remove($student);
    $this->em->flush();

    return $this->redirectToRoute('~student.index');
  }
}
