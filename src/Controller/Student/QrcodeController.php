<?php

namespace App\Controller\Student;

use App\Entity\Qrcode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/student', name: '#')]
class QrcodeController extends AbstractController
{
  #[Route('/qrcode', name: 'qrcode.index', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('student/qrcode/index.html.twig');
  }

  #[Route('/qrcode/{id}', name: 'qrcode.show', methods: ['GET'])]
  public function show(Qrcode $qrcode): Response
  {
    return $this->render('student/qrcode/show.html.twig', [
      'qrcode' => $qrcode
    ]);
  }
}
