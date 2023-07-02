<?php

namespace App\Command;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
        parent::__construct();
    }

    // php bin/console app:user:create +375295733121 aidsads@gmail.com mypassword ROLE_CLIENT(option)
    public function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Create a new user')
            ->addArgument('phone', InputArgument::REQUIRED, 'The phone of the user')
            ->addArgument('email', InputArgument::REQUIRED, 'The username of the user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user')
            ->addArgument('role', InputArgument::OPTIONAL, 'The user role');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $phone = $input->getArgument('phone');
        $email = $input->getArgument('email');
        $passwordPlain = $input->getArgument('password');
        $role = $input->getArgument('role') ?? 'ROLE_ADMIN';

        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $passwordPlain);

        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setPassword($hashedPassword);
        $user->setRoles([$role]);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln("<info>User with phone {$phone}, password {$passwordPlain} and role= {$role} has been successfully created</info>");

        return Command::SUCCESS;
    }
}