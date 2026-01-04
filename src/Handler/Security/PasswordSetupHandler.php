<?php

declare(strict_types=1);

namespace App\Handler\Security;

use App\Entity\Security\User;
use App\Repository\Security\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordSetupHandler
{
    public function __construct(
        private UserRepository $userRepository,
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

        $this->userRepository->save($user);
    }
}
