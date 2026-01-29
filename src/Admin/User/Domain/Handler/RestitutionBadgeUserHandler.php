<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;

class RestitutionBadgeUserHandler
{
    public function __construct(private readonly UserWriteRepositoryInterface $userWriteRepository)
    {
    }

    public function handle(User $user): void
    {
        $user->restitutionBadge();

        $this->userWriteRepository->save($user);
    }
}
