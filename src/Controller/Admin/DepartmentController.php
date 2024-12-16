<?php


namespace App\Controller\Admin;

use App\Entity\Department;
use App\Form\DepartmentFormType;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class DepartmentController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

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

    return $this->render('admin/department/index.html.twig', [
      'departments' => $departments
    ]);
  }

  #[Route('/department/{id}', name: 'department.show', methods: ['GET'], requirements: ['id' => "[0-9]+"])]
  public function show(Department $department): Response
  {
    return $this->render('admin/department/show.html.twig', compact('department'));
  }

  #[Route('/department/{id}/edit', name: 'department.edit', methods: ['GET', 'POST'], requirements: ['id' => "[0-9]+"])]
  public function edit(Request $request, Department $department): Response|RedirectResponse
  {
    $form = $this->createForm(DepartmentFormType::class, $department);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $department->setUpdatedAt(new \DateTime());

      $this->em->persist($department);
      $this->em->flush();

      return $this->redirectToRoute('~department.index');
    }

    return $this->render('admin/department/edit.html.twig', [
      'form' => $form,
      'department' => $department,
    ]);
  }

  #[Route('/department/create', name: 'department.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $department = new Department();

    $form = $this->createForm(DepartmentFormType::class, $department);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($department);
      $this->em->flush();

      return $this->redirectToRoute('~department.index');
    }

    return $this->render('admin/department/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/department/{id}/delete', name: 'department.delete', methods: ['DELETE'], requirements: ['id' => "[0-9]+"])]
  public function delete(Department $department): RedirectResponse
  {
    $this->em->remove($department);
    $this->em->flush();

    return $this->redirectToRoute('~department.index');
  }
}
