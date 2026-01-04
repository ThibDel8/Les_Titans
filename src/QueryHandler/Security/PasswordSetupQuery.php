<?php

declare(strict_types=1);

namespace App\QueryHandler\Security;

use App\Entity\Security\User;
use App\Repository\Security\UserRepository;

class PasswordSetupQuery
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getUserFromToken(string $token): User
    {
        $user = $this->userRepository->findOneBy(['passwordSetupToken' => $token]);

        if (!$user) {
            throw new \InvalidArgumentException('Invalid token');
        }

        if ($user->getPasswordSetupTokenExpiresAt() < new \DateTimeImmutable()) {
            throw new \RuntimeException('Token has expired');
        }

        return $user;
    }
}
