<?php

declare(strict_types=1);

namespace App\QueryHandler\Member;

use App\Entity\Member\Member;
use App\Repository\Member\MemberRepository;

class MemberListQueryHandler
{
    public function __construct(private MemberRepository $memberRepository)
    {
    }

    public function fetch(): array
    {
        $now = new \DateTimeImmutable('now');
        $members = $this->memberRepository->findBy([], ['firstname' => 'ASC']);

        $validMembers = [];
        $invalidMembers = [];
        /** @var Member $member */
        foreach ($members as $member) {
            if ($member->isValid($now)) {
                $validMembers[] = $member;
            } else {
                $invalidMembers[] = $member;
            }
        }

        return [
            'validMembers' => $validMembers,
            'invalidMembers' => $invalidMembers,
        ];
    }
}
