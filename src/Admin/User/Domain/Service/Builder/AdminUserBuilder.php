<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Service\Builder;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Gender;
use App\SharedKernel\Domain\Enum\Role;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class AdminUserBuilder
{
    public function __construct(
        private int $annualFee,
        private int $accessBadgeDeposit,
        private ParameterBagInterface $parameterBag,
        private UserPasswordHasherInterface $hasher,
        private ProfileImageService $profileImageService,
    ) {
    }

    public function build(): User
    {
        $adminProfileImagePath = $this->profileImageService->getDefaultsDir().ProfileImageService::ADMIN_PROFILE;

        $adminUser = User::create(
            lastname: $this->parameterBag->get('admin.init.lastname'),
            firstname: $this->parameterBag->get('admin.init.firstname'),
            birthdate: new \DateTimeImmutable($this->parameterBag->get('admin.init.birthdate')),
            gender: Gender::tryFrom($this->parameterBag->get('admin.init.gender')) ?? Gender::Other,
            phone: $this->parameterBag->get('admin.init.phone'),
            address: $this->parameterBag->get('admin.init.address'),
            postalcode: $this->parameterBag->get('admin.init.postalcode'),
            city: $this->parameterBag->get('admin.init.city'),
            email: $this->getEmail(),
            medicalCertificateExpiry: new \DateTimeImmutable('2099-01-01'),
            accessBadgeDeposit: $this->accessBadgeDeposit,
            annualMembershipFee: $this->annualFee,
            profileImage: $this->profileImageService->save($adminProfileImagePath),
        );

        $adminUser->giveBadgeNumber('0009559203');
        $adminUser->assignRoles([Role::Admin->value]);

        $hashedPassword = $this->hasher->hashPassword($adminUser, $this->parameterBag->get('admin.init.password'));
        $adminUser->setPassword($hashedPassword);

        return $adminUser;
    }

    public function getEmail(): string
    {
        return $this->parameterBag->get('admin.init.email');
    }
}
