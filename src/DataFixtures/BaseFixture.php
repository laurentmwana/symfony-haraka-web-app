<?php

namespace App\DataFixtures;

use App\Entity\Sector;
use App\Entity\Faculty;
use App\Entity\Programme;
use App\Entity\Department;
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

        foreach ($newProgrammes as $programme) {
            $p = (new Programme())
                ->setName($programme['name'])
                ->setAlias($programme['alias']);

            $manager->persist($p);

            $programmes[] = $p;
        }

        $faker = \Faker\Factory::create();

        $faculties = [];

        for ($index = 0; $index < 12; $index++) {
            $f = (new Faculty())->setName($faker->text(100));
            $manager->persist($f);

            $faculties[] = $f;
        }

        $departments = [];
        foreach ($faculties as $faculty) {
            for ($index = 0; $index < 3; $index++) {
                $name = $faker->text(100);
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
                $name = $faker->text(100);
                $s = (new Sector())
                    ->setName($name)
                    ->setAlias(substr($name, 0, 8))
                    ->setDepartment($department);
                $manager->persist($s);

                $sectors[] = $s;
            }
        }


        $manager->flush();
    }
}
