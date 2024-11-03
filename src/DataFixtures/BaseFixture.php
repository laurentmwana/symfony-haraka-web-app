<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\{
    User,
    Level,
    Amount,
    Sector,
    Checker,
    Faculty,
    Student,
    Programme,
    Department,
    ActualLevel,
    Installment,
    YearAcademic
};
use App\Enum\{
    RoleEnum,
    GenderEnum
};
use App\Helpers\Number;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BaseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadYears($manager, 2012, 2022);

        $programmes = $this->loadProgrammes($manager);

        $faculties = $this->loadFaculties($manager, 12);
        $departments = $this->loadDepartments($manager, $faculties);
        $sectors = $this->loadSectors($manager, $departments);

        $year = $this->getLatestYear($manager);
        $levels = $this->loadLevels($manager, $programmes, $sectors, $year);
        $checkers = $this->loadCheckers($manager, 100);

        $this->loadAdmin($manager);
        $this->loadCheckerUsers($manager, $checkers);
        $this->loadStudents($manager, $levels, 40);

        $manager->flush();
    }

    private function loadYears(ObjectManager $manager, int $startYear, int $endYear): void
    {
        for ($year = $startYear; $year <= $endYear; $year++) {
            $academicYear = (new YearAcademic())->setName("{$year}-" . ($year + 1));
            if ($year < $endYear) {
                $academicYear->setClosed(true)->setClosedAt(new \DateTime());
            }
            $manager->persist($academicYear);
        }

        $manager->flush();
    }

    private function loadProgrammes(ObjectManager $manager): array
    {
        $programmeData = [
            ['name' => 'Licence 1', 'alias' => 'L1'],
            ['name' => 'Licence 2', 'alias' => 'L2'],
            ['name' => 'Licence 3', 'alias' => 'L3'],
            ['name' => 'Master 1', 'alias' => 'M1'],
            ['name' => 'Master 2', 'alias' => 'M2'],
            ['name' => 'Doctorat 1', 'alias' => 'D1'],
            ['name' => 'Doctorat 2', 'alias' => 'D2'],
        ];

        $programmes = [];
        foreach ($programmeData as $data) {
            $programme = (new Programme())
                ->setName($data['name'])
                ->setAlias($data['alias']);
            $manager->persist($programme);
            $programmes[] = $programme;
        }

        return $programmes;
    }

    private function loadFaculties(ObjectManager $manager, int $count): array
    {
        $faker = Factory::create();
        $faculties = [];
        for ($i = 0; $i < $count; $i++) {
            $faculty = (new Faculty())->setName($faker->text(15));
            $manager->persist($faculty);
            $faculties[] = $faculty;
        }
        return $faculties;
    }

    private function loadDepartments(ObjectManager $manager, array $faculties): array
    {
        $faker = Factory::create();
        $departments = [];
        foreach ($faculties as $faculty) {
            for ($i = 0; $i < 3; $i++) {
                $department = (new Department())
                    ->setName($name = $faker->text(20))
                    ->setAlias(substr($name, 0, 8))
                    ->setFaculty($faculty);
                $manager->persist($department);
                $departments[] = $department;
            }
        }
        return $departments;
    }

    private function loadSectors(ObjectManager $manager, array $departments): array
    {
        $faker = Factory::create();
        $sectors = [];
        foreach ($departments as $department) {
            for ($i = 0; $i < 2; $i++) {
                $sector = (new Sector())
                    ->setName($name = $faker->text(10))
                    ->setAlias(substr($name, 0, 8))
                    ->setDepartment($department);
                $manager->persist($sector);
                $sectors[] = $sector;
            }
        }
        return $sectors;
    }

    private function getLatestYear(ObjectManager $manager): YearAcademic
    {
        return $manager->getRepository(YearAcademic::class)
            ->findOneBy(['closed' => 0]);
    }

    private function loadLevels(ObjectManager $manager, array $programmes, array $sectors, YearAcademic $year): array
    {
        $levels = [];
        foreach ($programmes as $programme) {
            $amount = (new Amount())
                ->setYearAcademic($year)
                ->setProgramme($programme)
                ->setPrice($price = random_int(400000, 600000))
                ->setMaxNumberInstallment($installments = random_int(1, 6));

            foreach (Number::divideIntoInstallments($price, $installments) as $key => $pricePart) {
                $installment = (new Installment())->setPrice($pricePart)->setPriority($key + 1);
                $amount->addInstallment($installment);
            }

            $manager->persist($amount);

            $level = (new Level())
                ->setProgramme($programme)
                ->setSector($sectors[array_rand($sectors)])
                ->setYearAcademic($year);
            $manager->persist($level);
            $levels[] = $level;
        }
        return $levels;
    }

    private function loadCheckers(ObjectManager $manager, int $count): array
    {
        $faker = Factory::create();
        $checkers = [];
        for ($i = 0; $i < $count; $i++) {
            $checker = (new Checker())
                ->setName($faker->name())
                ->setFirstname($faker->firstName())
                ->setGender(GenderEnum::FEMALE)
                ->setNumberPhone($faker->phoneNumber());
            $manager->persist($checker);
            $checkers[] = $checker;
        }
        return $checkers;
    }

    private function loadAdmin(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setUsername('padoda')
            ->setRoles([RoleEnum::ROLE_ADMIN->value])
            ->setEmail('admin@gmail.com')
            ->setPassword('$2y$13$A4SPgHvZ5jWVqNkvFErFcuw6/ceNhxOBIYQK4nIoIBWbunkdBjN/O');
        $manager->persist($admin);
    }

    private function loadCheckerUsers(ObjectManager $manager, array $checkers): void
    {
        $faker = Factory::create();
        foreach ($checkers as $checker) {
            $user = (new User())
                ->setUsername($faker->unique()->userName())
                ->setRoles([RoleEnum::ROLE_CHECKER->value])
                ->setEmail($faker->email())
                ->setPassword('$2y$13$A4SPgHvZ5jWVqNkvFErFcuw6/ceNhxOBIYQK4nIoIBWbunkdBjN/O')
                ->setChecker($checker);
            $manager->persist($user);
        }
    }

    private function loadStudents(ObjectManager $manager, array $levels, int $count): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < $count; $i++) {
            $student = (new Student())
                ->setName($faker->name())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setGender(GenderEnum::FEMALE)
                ->setHappy($faker->dateTimeBetween())
                ->setNumberPhone($faker->phoneNumber());

            $user = (new User())
                ->setUsername($faker->unique()->userName())
                ->setRoles([RoleEnum::ROLE_STUDENT->value])
                ->setEmail($faker->email())
                ->setPassword('$2y$13$A4SPgHvZ5jWVqNkvFErFcuw6/ceNhxOBIYQK4nIoIBWbunkdBjN/O')
                ->setStudent($student);

            $assignedLevels = array_slice($levels, $faker->numberBetween(0, count($levels) - 3), 3);
            $actualLevel = (new ActualLevel())->setLevel(end($assignedLevels));
            $student->setActualLevel($actualLevel);

            foreach ($assignedLevels as $level) {
                $level->addStudent($student);
                $manager->persist($level);
            }

            $manager->persist($student);
            $manager->persist($user);
        }
    }
}
