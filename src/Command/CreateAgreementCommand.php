<?php

namespace App\Command;

use App\Entity\Agreement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAgreementCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('app:user:agreement');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $agreement = new Agreement();

        $this->em->persist($agreement);
        $this->em->flush();

        return Command::SUCCESS;
    }
}