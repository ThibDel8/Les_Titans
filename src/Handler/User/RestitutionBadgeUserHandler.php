<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Entity\Security\User;
use App\Repository\Security\UserRepository;

class RestitutionBadgeUserHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(User $user): void
    {
        $user->restitutionBadge();

        $this->userRepository->save($user);
    }
}
