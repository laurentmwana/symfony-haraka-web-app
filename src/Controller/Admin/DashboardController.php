<?php


namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
  #[Route('/dashboard', name: 'dashboard.index', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('admin/dashboard/index.html.twig');
  }
}
