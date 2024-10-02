<?php

namespace App\Controller\Admin;

use App\Entity\Sector;
use App\Form\SectorFormType;
use App\Repository\SectorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class SectorController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {}

  #[Route('/sector', name: 'sector.index', methods: ['GET'])]
  public function index(
    SectorRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {
    $sectors = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/sector/index.html.twig', [
      'sectors' => $sectors
    ]);
  }

  #[Route('/sector/{id}', name: 'sector.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Sector $sector): Response
  {
    return $this->render('admin/sector/show.html.twig', compact('sector'));
  }

  #[Route('/sector/{id}/edit', name: 'sector.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, Sector $sector): Response|RedirectResponse
  {
    $form = $this->createForm(SectorFormType::class, $sector);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $sector->setUpdatedAt(new \DateTime());

      $this->em->persist($sector);
      $this->em->flush();

      return $this->redirectToRoute('~sector.index');
    }

    return $this->render('admin/sector/edit.html.twig', [
      'form' => $form,
      'sector' => $sector,
    ]);
  }

  #[Route('/sector/create', name: 'sector.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $sector = new Sector();

    $form = $this->createForm(SectorFormType::class, $sector);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($sector);
      $this->em->flush();

      return $this->redirectToRoute('~sector.index');
    }

    return $this->render('admin/sector/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/sector/{id}/delete', name: 'sector.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(Sector $sector): RedirectResponse
  {
    $this->em->remove($sector);
    $this->em->flush();

    return $this->redirectToRoute('~sector.index');
  }
}
