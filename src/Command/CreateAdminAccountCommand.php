<?php

namespace App\Command;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use App\SharedKernel\Domain\Enum\Gender;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin-account',
    description: 'Création du compte Admin.',
)]
class CreateAdminAccountCommand extends Command
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly ParameterBagInterface $parameterBag,
        private readonly ProfileImageService $profileImageService,
        private readonly UserReadRepositoryInterface $userReadRepository,
        private readonly UserWriteRepositoryInterface $userWriteRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $this->parameterBag->get('admin.init.email');
        $password = $this->parameterBag->get('admin.init.password');
        $lastname = $this->parameterBag->get('admin.init.lastname');
        $firstname = $this->parameterBag->get('admin.init.firstname');
        $birthday = $this->parameterBag->get('admin.init.birthdate');
        $phone = $this->parameterBag->get('admin.init.phone');
        $address = $this->parameterBag->get('admin.init.address');
        $postalcode = $this->parameterBag->get('admin.init.postalcode');
        $city = $this->parameterBag->get('admin.init.city');
        $existing = $this->userReadRepository->findByEmail($email);

        if ($existing) {
            $output->writeln('Admin déjà existant');

            return Command::FAILURE;
        }

        $user = User::create(
            lastname: $lastname,
            firstname: $firstname,
            birthdate: new \DateTimeImmutable($birthday),
            gender: Gender::Male,
            phone: $phone,
            address: $address,
            postalcode: (int) $postalcode,
            city: $city,
            email: $email,
            medicalCertificateExpiry: new \DateTimeImmutable('2099-01-01'),
            accessBadgeDeposit: 10,
            annualMembershipFee: 50,
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir().ProfileImageService::ADMIN_PROFILE),
        );

        $user->giveBadgeNumber('0009559203');
        $user->assignRoles([Role::Admin->value]);

        $hashedPassword = $this->hasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->userWriteRepository->save($user);

        $output->writeln('Admin créé avec succès');

        return Command::SUCCESS;
    }
}
