<?php

namespace App\DataFixtures;

use App\Entity\Paid;
use App\Enum\PaidEnum;
use App\Entity\Payment;
use App\Repository\AmountRepository;
use App\Repository\PaidRepository;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PaidFixtures extends Fixture
{
    public function __construct(
        private PaidRepository $paidRepository,
        private StudentRepository $studentRepository,
        private AmountRepository $amountRepository
    ) {}

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        foreach (
            $this->studentRepository
                ->findAll() as $student
        ) {
            $levels = $student->getLevels();



            for ($index = 0; $index < $levels->count() - 1; $index++) {
                $l = $levels[$index];
                $paid = $this->paidRepository
                    ->findOneBy([
                        'level' => $l,
                        'student' => $student
                    ]);

                $amount = $this->amountRepository->findAllForLevel($l);
                foreach ($amount->getInstallments() as $installment) {
                    $pay = (new Payment())
                        ->setAmount($amount)
                        ->setStudent($student)
                        ->setLevel($l)
                        ->setInstallment($installment);

                    $manager->persist($pay);
                }

                if ($paid instanceof Paid) {

                    $paid->setState(PaidEnum::TOTALITY);
                    $manager->persist($paid);
                }
            }
        }


        $manager->flush();
    }
}
