<?php


namespace App\Controller\Admin;

use App\Entity\Quiz;
use App\Form\QuizFormType;
use App\Form\AmountFormType;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstallmentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: '~')]
class QuizController extends AbstractController
{
  public function __construct(
    private EntityManagerInterface $em,
    private InstallmentRepository $installmentRepository,
  ) {}

  #[Route('/quiz', name: 'quiz.index', methods: ['GET'])]
  public function index(
    QuizRepository $repository,
    PaginatorInterface $paginator,
    Request $request
  ): Response {

    $quizzes = $paginator->paginate(
      $repository->findSearchQuery($request->get('query')),
      $request->get('page', 1)
    );

    return $this->render('admin/quiz/index.html.twig', [
      'quizzes' => $quizzes
    ]);
  }

  #[Route('/quiz/{id}', name: 'quiz.show', methods: ['GET'], requirements: ['id' => REGEX_ID])]
  public function show(Quiz $quiz): Response
  {
    return $this->render('admin/quiz/show.html.twig', compact('quiz'));
  }

  #[Route('/quiz/{id}/edit', name: 'quiz.edit', methods: ['GET', 'POST'], requirements: ['id' => REGEX_ID])]
  public function edit(Request $request, Quiz $quiz): Response|RedirectResponse
  {
    $form = $this->createForm(QuizFormType::class, $quiz);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $this->em->persist($quiz);
      $this->em->flush();


      return $this->redirectToRoute('~quiz.index');
    }

    return $this->render('admin/quiz/edit.html.twig', [
      'form' => $form,
      'quiz' => $quiz,
    ]);
  }

  #[Route('/quiz/create', name: 'quiz.create', methods: ['GET', 'POST'])]
  public function create(Request $request): Response|RedirectResponse
  {
    $quiz = new Quiz();

    $form = $this->createForm(AmountFormType::class, $quiz);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->persist($quiz);
      $this->em->flush();

      return $this->redirectToRoute('~quiz.index');
    }

    return $this->render('admin/quiz/create.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/quiz/{id}/delete', name: 'quiz.delete', methods: ['DELETE'], requirements: ['id' => REGEX_ID])]
  public function delete(Quiz $quiz): RedirectResponse
  {
    $this->em->remove($quiz);
    $this->em->flush();

    return $this->redirectToRoute('~quiz.index');
  }
}
