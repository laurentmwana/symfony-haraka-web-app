<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OnlyEntityFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $faker = Factory::create();

        for ($index = 1; $index <= 10; $index++) {

            $quiz = (new Quiz())
                ->setRequest($faker->text(120))
                ->setResponse($faker->text(200))
                ->setFeatured(true);

            $manager->persist($quiz);
        }

        $manager->flush();
    }
}
