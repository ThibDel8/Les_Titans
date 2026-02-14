<?php

declare(strict_types=1);

namespace App\Security\Domain\QueryHandler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;

class PasswordSetupQuery
{
    public function __construct(private UserReadRepositoryInterface $userReadRepository)
    {
    }

    public function getUserFromToken(string $token): User
    {
        $user = $this->userReadRepository->findByPasswordToken($token);

        if (!$user) {
            throw new \InvalidArgumentException('Invalid token');
        }

        if ($user->getPasswordSetupTokenExpiresAt() < new \DateTimeImmutable()) {
            throw new \RuntimeException('Token has expired');
        }

        return $user;
    }
}
