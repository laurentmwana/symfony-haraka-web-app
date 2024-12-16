<?php


namespace App\Controller\Admin;

use App\Entity\Faculty;
use App\Form\FacultyFormType;
use App\Repository\FacultyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
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

    return $this->render('admin/faculty/index.html.twig', [
      'faculties' => $faculties
    ]);
  }

  #[Route('/faculty/{id}', name: 'faculty.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Faculty $faculty): Response
  {
    return $this->render('admin/faculty/show.html.twig', compact('faculty'));
  }

  #[Route('/faculty/{id}/edit', name: 'faculty.edit', methods: ['GET', 'POST'], requirements: ['id' => "[0-9]+"])]
  public function edit(Request $request, Faculty $faculty): Response|RedirectResponse
  {
    $form = $this->createForm(FacultyFormType::class, $faculty);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $faculty->setUpdatedAt(new \DateTime());

      $this->em->persist($faculty);
      $this->em->flush();

      return $this->redirectToRoute('~faculty.index');
    }

    return $this->render('admin/faculty/edit.html.twig', [
      'form' => $form,
      'faculty' => $faculty,
    ]);
  }

  #[Route('/faculty/create', name: 'faculty.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $faculty = new Faculty();

    $form = $this->createForm(FacultyFormType::class, $faculty);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($faculty);
      $this->em->flush();

      return $this->redirectToRoute('~faculty.index');
    }

    return $this->render('admin/faculty/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/faculty/{id}/delete', name: 'faculty.delete', methods: ['DELETE'], requirements: ['id' => "[0-9]+"])]
  public function delete(Faculty $faculty): RedirectResponse
  {
    $this->em->remove($faculty);
    $this->em->flush();

    return $this->redirectToRoute('~faculty.index');
  }
}
