<?php

declare(strict_types=1);

namespace App\Security\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordSetupHandler
{
    public function __construct(
        private UserWriteRepositoryInterface $userWriteRepository,
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function handle(User $user, string $password): void
    {
        $user->setPassword($this->hasher->hashPassword(
            user: $user,
            plainPassword: $password
        ));

        $user->setPasswordSetupToken(null);
        $user->setPasswordSetupTokenExpiresAt(null);

        $this->userWriteRepository->save($user);
    }
}
