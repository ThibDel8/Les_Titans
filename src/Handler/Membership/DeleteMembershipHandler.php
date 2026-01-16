<?php

declare(strict_types=1);

namespace App\Handler\Membership;

use App\Entity\Membership\Membership;
use App\Repository\Membership\MembershipRepository;
use App\Service\ProfileImage\ProfileImageService;

final class DeleteMembershipHandler
{
    public function __construct(
        private MembershipRepository $membershipRepository,
        private ProfileImageService $profileImageService,
    )
    {
    }

    public function handle(Membership $membership): void
    {
        $this->membershipRepository->delete($membership);

        $this->profileImageService->remove($membership->getProfileImage());
    }
}
