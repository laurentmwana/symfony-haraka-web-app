<?php

namespace App\Controller\Admin;

use App\Entity\Sector;
use App\Entity\YearAcademic;
use App\Form\SectorFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\YearAcademicRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class YearAcademicController extends AbstractController
{
  // public function __construct(private EntityManagerInterface $em) {}

  #[Route('/year-academic', name: 'year-academic.index', methods: ['GET'])]
  public function index(
    YearAcademicRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $years = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/year-academic/index.html.twig', [
      'years' => $years
    ]);
  }

  #[Route('/year-academic/{id}', name: 'year-academic.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(YearAcademic $yearAcademic): Response
  {
    return $this->render('admin/year-academic/show.html.twig', [
      'year' => $yearAcademic
    ]);
  }


  #[Route('/year-academic/{id}/closed', name: 'year-academic.closed', methods: ['GET', 'POST'])]
  public function create(Request $request, YearAcademic $yearAcademic): Response|RedirectResponse
  {

    return $this->render('admin/year-academic/closed.html.twig', [
      'year' => $yearAcademic
    ]);
  }
}
