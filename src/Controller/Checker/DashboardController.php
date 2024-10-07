<?php

namespace App\Controller\Checker;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/checker', name: '^')]
class DashboardController extends AbstractController
{
  #[Route('/dashboard', name: 'dashboard', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('checker/dashboard/index.html.twig');
  }
}
