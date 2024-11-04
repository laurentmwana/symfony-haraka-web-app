<?php

namespace App\Twig\Runtime;

use App\Entity\YearAcademic;
use App\Repository\YearAcademicRepository;
use Twig\Extension\RuntimeExtensionInterface;

class GetDataRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly YearAcademicRepository $yearAcademicRepository
    ) {
        // Inject dependencies if needed
    }

    public function getCurrentYear(): YearAcademic
    {
        return $this->yearAcademicRepository->findCurrentYear();
    }
}
