<?php

namespace App\Command;

use App\Entity\User;
use App\Enum\RoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'seed:admin',
    description: 'Add a short description for your command',
)]
class SeedAdminCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $admin = (new User())
            ->setUsername('padoda')
            ->setRoles([RoleEnum::ROLE_ADMIN->value])
            ->setEmail('admin@gmail.com')
            ->setPassword('$2y$13$A4SPgHvZ5jWVqNkvFErFcuw6/ceNhxOBIYQK4nIoIBWbunkdBjN/O');

        $this->em->persist($admin);
        $this->em->flush();

        $io->success('ADMIN USER created');

        return Command::SUCCESS;
    }
}
