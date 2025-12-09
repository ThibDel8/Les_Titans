<?php

namespace App\Command;

use App\Entity\Member\Member;
use App\Enum\Security\Role;
use App\Entity\Security\User;
use App\Enum\Membership\Gender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin-account',
    description: "Création du compte Admin qui sera le seul à pouvoir créer d'autres nouveaux comptes.",
)]
class CreateAdminAccountCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $hasher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $existing = $this->manager->getRepository(User::class)
            ->findOneBy(['roles' => [Role::Admin]]);

        if ($existing) {
            return Command::FAILURE;
        }

        $member = Member::create(
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
            profileImage: 'admin.png',
        );

        $member->giveBadgeNumber('0009559203');

        $this->manager->persist($member);

        $user = User::create(
            member: $member,
            roles: [Role::Admin],
            email: $member->getEmail(),
        );

        $hashedPassword = $this->hasher->hashPassword($user, 'Adm!nF1rstC0nn3ct');
        $user->setPassword($hashedPassword);

        $this->manager->persist($user);
        $this->manager->flush();

        return Command::SUCCESS;
    }
}
