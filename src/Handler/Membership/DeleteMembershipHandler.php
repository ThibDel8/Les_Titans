<?php

declare(strict_types=1);

namespace App\Handler\Membership;

use App\Entity\Membership\Membership;
use App\Repository\Membership\MembershipRepository;
use App\Service\ProfileImage\ProfileImageService;

final class DeleteMembershipHandler
{
    public function __construct(
        private MembershipRepository $repository,
        private ProfileImageService $profileImageService,
    )
    {
    }

    public function handle(Membership $membership): void
    {
        $this->repository->delete($membership);

        $this->profileImageService->remove($membership->getProfileImage());
    }
}
