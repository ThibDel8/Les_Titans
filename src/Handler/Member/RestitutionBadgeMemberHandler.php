<?php

declare(strict_types=1);

namespace App\Handler\Member;

use App\Entity\Member\Member;
use App\Repository\Member\MemberRepository;

class RestitutionBadgeMemberHandler
{
    public function __construct(private MemberRepository $memberRepository)
    {
    }

    public function handle(Member $member): void
    {
        $member->restitutionBadge();

        $this->memberRepository->save($member);
    }
}
