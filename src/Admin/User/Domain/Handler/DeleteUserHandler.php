<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;

final class DeleteUserHandler
{
    public function __construct(
        private UserWriteRepositoryInterface $userWriteRepository,
        private ProfileImageService $profileImageService,
    ) {
    }

    public function handle(User $user): void
    {
        $profileImage = $user->getProfileImage();

        $this->userWriteRepository->delete($user);

        $this->profileImageService->remove($profileImage);
    }
}
