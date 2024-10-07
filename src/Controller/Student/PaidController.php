<?php

namespace App\Controller\Student;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class PaidController extends AbstractController
{
    #[Route('/paid', name: 'paid.index')]
    public function index(Request $request): Response
    {
        return $this->render('student/paid/index.html.twig', []);
    }
}
