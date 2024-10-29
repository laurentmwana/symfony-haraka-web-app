<?php


namespace App\Controller\Admin;

use App\Entity\ActualLevel;
use App\Entity\Student;
use App\Form\StudentFormType;
use App\Repository\LevelRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

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

  #[Route('/student/{id}', name: 'student.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Student $student): Response
  {
    return $this->render('admin/student/show.html.twig', compact('student'));
  }

  #[Route('/student/{id}/edit', name: 'student.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, Student $student): Response|RedirectResponse
  {
    $form = $this->createForm(StudentFormType::class, $student);

    $form->get('actualLevel')
      ->setData($student->getActualLevel()->getLevel());

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $newLevel = $this->getActualLevel($form)->getLevel();

      $student->removeLevel($student->getActualLevel()->getLevel());
      $student->addLevel($newLevel);

      $student->getActualLevel()->setLevel($newLevel);
      $student->getActualLevel()->setUpdatedAt(new \DateTime());

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

      $actualLevel = $this->getActualLevel($form);

      $student->setActualLevel($actualLevel);

      $student->addLevel($actualLevel->getLevel());

      $this->em->persist($student);
      $this->em->flush();

      return $this->redirectToRoute('~student.index');
    }

    return $this->render('admin/student/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/student/{id}/delete', name: 'student.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(Student $student): RedirectResponse
  {
    $this->em->remove($student);
    $this->em->flush();

    return $this->redirectToRoute('~student.index');
  }

  private function getActualLevel(FormInterface $form): ActualLevel
  {
    $level =  $form->get('actualLevel')->getData();

    if (null === $level) {
      throw new \RuntimeException("Nous n'avons pas pu trouvé cette promotion");
    }

    return (new ActualLevel())
      ->setLevel($level);
  }
}
