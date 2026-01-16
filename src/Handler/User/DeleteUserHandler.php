<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Entity\Security\User;
use App\Repository\Security\UserRepository;
use App\Service\ProfileImage\ProfileImageService;

final class DeleteUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private ProfileImageService $profileImageService,
        )
    {
    }

    public function handle(User $user): void
    {
        $profileImage = $user->getProfileImage();

        $this->userRepository->delete($user);

        $this->profileImageService->remove($profileImage);
    }
}
