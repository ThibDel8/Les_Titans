<?php

declare(strict_types=1);

namespace App\Admin\Membership\Domain\Handler;

use App\MemberApp\Membership\Domain\Entity\Membership;
use App\MemberApp\Membership\Domain\Repository\MembershipWriteRepositoryInterface;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;

final class DeleteMembershipHandler
{
    public function __construct(
        private ProfileImageService $profileImageService,
        private MembershipWriteRepositoryInterface $membershipWriteRepository,
    ) {
    }

    public function handle(Membership $membership): void
    {
        $this->membershipWriteRepository->delete($membership);

        $this->profileImageService->remove($membership->getProfileImage());
    }
}
