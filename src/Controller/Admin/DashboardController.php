<?php


namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Repository\UserRepository;
use App\Repository\LevelRepository;
use App\Repository\SectorRepository;
use App\Repository\CheckerRepository;
use App\Repository\FacultyRepository;
use App\Repository\StudentRepository;
use App\Repository\DepartmentRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
  public function __construct(
    private readonly FacultyRepository $facultyRepository,
    private readonly DepartmentRepository $departmentRepository,
    private readonly SectorRepository $sectorRepository,
    private readonly StudentRepository $studentRepository,
    private readonly LevelRepository $levelRepository,
    private readonly CheckerRepository $checkerRepository,
    private readonly UserRepository $userRepository,
    private readonly NotificationRepository $notificationRepository,
  ) {}

  #[Route('/dashboard', name: 'dashboard.index', methods: ['GET'])]
  public function index(): Response
  {
    $user = $this->getUser();

    if (!($user instanceof User)) {
      throw new \RuntimeException("user connected is not instance of entity USER");
    }

    return $this->render('admin/dashboard/index.html.twig', [
      'faculties' => $this->facultyRepository->count(),
      'departments' => $this->departmentRepository->count(),
      'sectors' => $this->sectorRepository->count(),
      'students' => $this->studentRepository->count(),
      'users' => $this->getUserStat(),
      'notifications' => $this->notificationRepository->findBy([
        'user' => $user,
      ])
    ]);
  }

  private function getUserStat(): bool|string
  {
    $countStudent = $this->userRepository->countUserForRole(RoleEnum::ROLE_STUDENT->value);
    $countChecker = $this->userRepository->countUserForRole(RoleEnum::ROLE_CHECKER->value);

    $data = [
      'student' => $countStudent,
      'checker' => $countChecker,
    ];

    return $this->json($data)->getContent();
  }
}
