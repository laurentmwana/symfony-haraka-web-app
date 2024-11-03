<?php

namespace App\Controller\Payment;

use App\Entity\Paid;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/paypal', name: '@')]
class PaypalController extends AbstractController
{

  #[Route('/paid/{id}', name: 'paid')]
  public function paid(Paid $paid): RedirectResponse
  {

    // traitement

    return $this->redirectToRoute('#enum.index', [
      'id' => $paid->getId()
    ]);
  }
}
