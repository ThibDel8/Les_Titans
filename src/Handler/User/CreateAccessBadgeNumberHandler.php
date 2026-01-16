<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Repository\Security\UserRepository;
use App\DTO\Request\User\UserAccessBadgeRequest;
use App\Entity\Security\User;

final class CreateAccessBadgeNumberHandler
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function handle(User $user, UserAccessBadgeRequest $request): void
    {
        $user->giveBadgeNumber($request->accessBadgeNumber);

        $this->repository->save($user);
    }
}
