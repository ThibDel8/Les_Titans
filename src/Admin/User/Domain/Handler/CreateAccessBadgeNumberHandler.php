<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\DTO\Request\UserAccessBadgeRequest;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;

final readonly class CreateAccessBadgeNumberHandler
{
    public function __construct(private UserWriteRepositoryInterface $userWriteRepository)
    {
    }

    public function handle(User $user, UserAccessBadgeRequest $request): void
    {
        $user->giveBadgeNumber($request->accessBadgeNumber);

        $this->userWriteRepository->save($user);
    }
}
