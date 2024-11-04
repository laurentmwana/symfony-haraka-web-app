<?php


namespace App\Controller\Base;

use App\Repository\AmountRepository;
use App\Repository\QuizRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
  public function __construct(
    private QuizRepository $quizRepository,
    private AmountRepository $amountRepository,
  ) {}

  #[Route('/', name: 'welcome')]
  public function index(): Response
  {
    return $this->render('welcome/welcome.html.twig', [
      'quizzes' => $this->quizRepository->findBy(['featured' => true]),
      'amounts' => $this->amountRepository->findByCurrentYearAcademic(),
    ]);
  }
}
