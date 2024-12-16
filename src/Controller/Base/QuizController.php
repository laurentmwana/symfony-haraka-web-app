<?php

namespace App\Controller\Base;

use App\Entity\Quiz;
use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizController extends AbstractController
{
    #[Route('/quiz/{id}', name: 'quiz.show', requirements: ['id' => "[0-9]+"])]
    public function show(Quiz $quiz): Response|RedirectResponse
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz
        ]);
    }
}
