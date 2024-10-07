<?php


namespace App\Controller\Student;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class DashboardController extends AbstractController
{
  #[Route('/dashboard', name: 'dashboard', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('student/dashboard/index.html.twig');
  }
}
