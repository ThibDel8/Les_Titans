<?php

namespace App\Command;

use App\Admin\User\Domain\Service\Builder\AdminUserBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;

#[AsCommand(
    name: 'app:create-admin-account',
    description: 'Création du compte Admin.',
)]
class CreateAdminAccountCommand extends Command
{
    public function __construct(
        private readonly AdminUserBuilder $builder,
        private readonly UserReadRepositoryInterface $userReadRepository,
        private readonly UserWriteRepositoryInterface $userWriteRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $this->builder->getEmail();
        $existing = $this->userReadRepository->findByEmail($email);

        if (null !== $existing) {
            $output->writeln('This email is already registered.');

            return Command::FAILURE;
        }

        $adminUser = $this->builder->build();
        $this->userWriteRepository->save($adminUser);

        $output->writeln('Admin account created.');

        return Command::SUCCESS;
    }
}
