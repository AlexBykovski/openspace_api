<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// php bin/console app:user:create +375295733121 aidsads@gmail.com mypassword ROLE_CLIENT(option)

class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Create a new user')
            ->addArgument('phone', InputArgument::REQUIRED, 'The phone of the user')
            ->addArgument('email', InputArgument::REQUIRED, 'The username of the user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user')
            ->addArgument('roles', InputArgument::OPTIONAL, 'The user role');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $phone = $input->getArgument('phone');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $roles = explode(',', $input->getArgument('roles')) ?? ['ROLE_ADMIN'];

        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $phone = preg_replace('/[^0-9]/', '', $phone);

        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setPassword($hashedPassword);
        $user->setRoles($roles);

        $this->em->persist($user);
        $this->em->flush();

        $rolesForOutput = implode(';', $roles);

        $output->writeln("<info>User with phone={$phone}, password={$passwordPlain} and roles={$rolesForOutput} has been successfully created</info>");

        return Command::SUCCESS;
    }

    public function createUser(string $phone, string $email, string $password, array $roles) {
        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        preg_replace('/[^0-9]/', '', $phone);

        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setPassword($hashedPassword);
        $user->setRoles($roles);

        preg_match('/^\d{5,15}$/', $phone, $test);

        $this->em->persist($user);
        $this->em->flush();
    }
}