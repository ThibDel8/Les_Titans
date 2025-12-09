<?php

declare(strict_types=1);

namespace App\Handler\Member;

use App\Entity\Member\Member;
use App\Repository\Member\MemberRepository;
use App\Service\ProfileImage\ProfileImageService;

final class DeleteMemberHandler
{
    public function __construct(
        private MemberRepository $memberRepository,
        private ProfileImageService $profileImageService,
        )
    {
    }

    public function handle(Member $member): void
    {
        $profileImage = $member->getProfileImage();

        $this->memberRepository->delete($member);

        $this->profileImageService->remove($profileImage);
    }
}
