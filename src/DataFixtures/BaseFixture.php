<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Level;
use App\Entity\Amount;
use App\Entity\Sector;
use App\Enum\RoleEnum;
use App\Entity\Checker;
use App\Entity\Faculty;
use App\Entity\Student;
use App\Helpers\Number;
use App\Enum\GenderEnum;
use App\Entity\Programme;
use App\Entity\Department;
use App\Entity\ActualLevel;
use App\Entity\Installment;
use App\Entity\YearAcademic;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BaseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $newProgrammes = [
            ['name' => 'Licence 1', 'alias' => 'L1'],
            ['name' => 'Licence 2', 'alias' => 'L2'],
            ['name' => 'Licence 3', 'alias' => 'L3'],
            ['name' => 'Master 1', 'alias' => 'M1'],
            ['name' => 'Master 2', 'alias' => 'M2'],
            ['name' => 'Doctorat 1', 'alias' => 'D1'],
            ['name' => 'Doctorat 2', 'alias' => 'D2'],
        ];

        $programmes = [];

        $years = [];
        for ($start = 2012; $start <= 2022; $start++) {
            $end = $start + 1;

            $name = $start . '-' . $end;

            $y = $start === 2022
                ? (new YearAcademic())
                ->setName($name)
                : (new YearAcademic())
                ->setName($name)->setClosed(true)
                ->setClosedAt(new \DateTime());

            $manager->persist($y);

            $years[] = $y;
        }

        foreach ($newProgrammes as $programme) {
            $p = (new Programme())
                ->setName($programme['name'])
                ->setAlias($programme['alias']);

            $manager->persist($p);

            $programmes[] = $p;
        }

        $faker = Factory::create();

        $faculties = [];

        for ($index = 0; $index < 12; $index++) {
            $f = (new Faculty())->setName($faker->text(15));
            $manager->persist($f);

            $faculties[] = $f;
        }

        $departments = [];
        foreach ($faculties as $faculty) {
            for ($index = 0; $index < 3; $index++) {
                $name = $faker->text(20);
                $d = (new Department())
                    ->setName($name)
                    ->setAlias(substr($name, 0, 8))
                    ->setFaculty($faculty);
                $manager->persist($d);

                $departments[] = $d;
            }
        }

        $sectors = [];
        foreach ($departments as $department) {
            for ($index = 0; $index < 2; $index++) {
                $name = $faker->text(10);
                $s = (new Sector())
                    ->setName($name)
                    ->setAlias(substr($name, 0, 8))
                    ->setDepartment($department);
                $manager->persist($s);

                $sectors[] = $s;
            }
        }

        $year = $years[count($years) - 1];


        $amounts = [];

        $levels = [];


        foreach ($programmes as $programme) {
            $price = (float)random_int(400000, 600000);
            $numberInstallment = random_int(1, 6);

            $amount = (new Amount())
                ->setYearAcademic($year)
                ->setProgramme($programme)
                ->setPrice($price)
                ->setMaxNumberInstallment($numberInstallment);

            $priceArray = Number::divideIntoInstallments(
                $price,
                $numberInstallment,
            );

            foreach ($priceArray as $key => $price) {
                $installment = (new Installment())
                    ->setPrice($price)
                    ->setPrice($price)
                    ->setPriority($key + 1);
                $amount->addInstallment($installment);
            }
            $manager->persist($amount);

            $sector = $sectors[random_int(0, count($sectors) - 1)];

            $l = (new Level())
                ->setProgramme($programme)
                ->setSector($sector)
                ->setYearAcademic($year);
            $manager->persist($l);

            $levels[] = $l;


            $amounts[] = $amount;
        }


        $checkers = [];

        for ($index = 0; $index < 100; $index++) {

            $c = (new Checker())
                ->setName($faker->text(100))
                ->setFirstname($faker->text())
                ->setGender(GenderEnum::from('F'))
                ->setNumberPhone($faker->phoneNumber());


            $manager->persist($c);


            $checkers[] = $c;
        }
        $manager->flush();



        $admin =  (new User())
            ->setUsername('padoda')
            ->setRoles([RoleEnum::ROLE_ADMIN->value])
            ->setEmail('admin@gmail.com')
            ->setPassword('$2y$13$A4SPgHvZ5jWVqNkvFErFcuw6/ceNhxOBIYQK4nIoIBWbunkdBjN/O');


        $manager->persist($admin);

        foreach ($checkers as $checker) {

            $user =  (new User())
                ->setUsername($faker->unique()->userName())

                ->setRoles([RoleEnum::ROLE_CHECKER->value])
                ->setEmail($faker->email())
                ->setPassword('$2y$13$A4SPgHvZ5jWVqNkvFErFcuw6/ceNhxOBIYQK4nIoIBWbunkdBjN/O')
                ->setChecker($checker);
            $manager->persist($user);
        }

        $extractLevels = function () use ($levels, $faker) {
            $maxStartIndex = count($levels) - 3;
            $startIndex = $faker->numberBetween(0, $maxStartIndex);

            return array_slice($levels, $startIndex, 3);
        };



        $students = [];

        for ($index = 0; $index < 100; $index++) {

            $s = (new Student())
                ->setName($faker->name())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setHappy($faker->dateTimeBetween())
                ->setGender(GenderEnum::from('F'))
                ->setNumberPhone($faker->phoneNumber());


            $user =  (new User())
                ->setUsername($faker->unique()->userName())

                ->setRoles([RoleEnum::ROLE_STUDENT->value])
                ->setEmail($faker->email())
                ->setPassword('$2y$13$A4SPgHvZ5jWVqNkvFErFcuw6/ceNhxOBIYQK4nIoIBWbunkdBjN/O')
                ->setStudent($s);

            $maxStartIndex = count($levels) - 3;
            $startIndex = $faker->numberBetween(0, $maxStartIndex);

            $randomLevels = array_slice($levels, $startIndex, 3);

            $randomLevel = $randomLevels[count($randomLevels) - 1];

            $actualLevel = (new ActualLevel())
                ->setLevel($randomLevel);

            $s->setActualLevel($actualLevel);

            foreach ($randomLevels as $l) {
                $l->addStudent($s);

                $manager->persist($l);
            }
            $manager->persist($s);
            $manager->persist($user);

            $students[] = $s;
        }
    }
}
