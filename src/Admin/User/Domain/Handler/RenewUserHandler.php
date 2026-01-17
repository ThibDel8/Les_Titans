<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;

class RenewUserHandler
{
    public function __construct(private UserWriteRepositoryInterface $userWriteRepository)
    {
    }

    public function handle(User $user): void
    {
        $user->renewMembership();

        $this->userWriteRepository->save($user);
    }
}
