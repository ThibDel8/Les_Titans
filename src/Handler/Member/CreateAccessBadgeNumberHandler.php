<?php

declare(strict_types=1);

namespace App\Handler\Member;

use App\Entity\Member\Member;
use App\Repository\Member\MemberRepository;
use App\DTO\Request\Member\MemberAccessBadgeRequest;

final class CreateAccessBadgeNumberHandler
{
    public function __construct(private MemberRepository $repository)
    {
    }

    public function handle(Member $member, MemberAccessBadgeRequest $request): void
    {
        $member->giveBadgeNumber($request->accessBadgeNumber);

        $this->repository->save($member);
    }
}
