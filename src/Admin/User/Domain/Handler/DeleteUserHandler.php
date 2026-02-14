<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use App\Admin\User\Domain\Service\Mailer\UserMailer;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;

final readonly class DeleteUserHandler
{
    public function __construct(
        private UserMailer $userMailer,
        private ProfileImageService $profileImageService,
        private UserReadRepositoryInterface $userReadRepository,
        private UserWriteRepositoryInterface $userWriteRepository,
    ) {
    }

    public function handle(User $user): void
    {
        $profileImage = $user->getProfileImage();

        $role = $user->getRoles();

        $this->userWriteRepository->delete($user);

        $this->profileImageService->remove($profileImage);

        if ($role !== Role::Member->value) {
            $president = $this->userReadRepository->findPresident();

            if (null === $president) {
                return;
            }

            $this->userMailer->notifyPresidentOfUserDeletion($user, $president);
        }
    }
}
