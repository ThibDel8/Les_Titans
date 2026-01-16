<?php

namespace App\Command;

use App\Enum\Security\Role;
use App\Entity\Security\User;
use App\Enum\Membership\Gender;
use App\Repository\Security\UserRepository;
use Symfony\Component\Console\Command\Command;
use App\Service\ProfileImage\ProfileImageService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin-account',
    description: "Création du compte Admin.",
)]
class CreateAdminAccountCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $hasher,
        private ProfileImageService $profileImageService,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $existing = $this->userRepository->findOneBy(['email' => 'delattre.thibault8@gmail.com']);

        if ($existing) {
            $output->writeln('Admin déjà existant');
            return Command::FAILURE;
        }

        $user = User::create(
            lastname: 'Delattre',
            firstname: 'Thibault',
            birthdate: new \DateTimeImmutable('1994-09-11'),
            gender: Gender::Male,
            phone: '0669109348',
            address: '17 rue du Général de Gaulle',
            postalcode: 80610,
            city: 'Saint-Ouen',
            email: 'delattre.thibault8@gmail.com',
            medicalCertificateExpiry: new \DateTimeImmutable('2027-01-01'),
            accessBadgeDeposit: 10,
            annualMembershipFee: 50,
            profileImage: $this->profileImageService->save($this->profileImageService->getDefaultsDir() . ProfileImageService::ADMIN_PROFILE),
        );

        $user->giveBadgeNumber('0009559203');
        $user->assignRoles([Role::Admin->value]);

        $hashedPassword = $this->hasher->hashPassword($user, 'Adm!nF1rstC0nn3ct');
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);

        $output->writeln('Admin créé avec succès');

        return Command::SUCCESS;
    }
}
