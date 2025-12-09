<?php

declare(strict_types=1);

namespace App\QueryHandler\Home;

use App\Repository\Member\MemberRepository;
use App\Repository\Membership\MembershipRepository;
use App\Repository\Security\UserRepository;

class HomeQueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private MemberRepository $memberRepository,
        private MembershipRepository $membershipRepository,
    ) {
    }

    public function fetch(): array
    {
        $users = $this->userRepository->findAll();
        $members = $this->memberRepository->findAll();
        $messages = [];
        $memberships = $this->membershipRepository->findAll();

        return [
            'users' => $users,
            'members' => $members,
            'messages' => $messages,
            'memberships' => $memberships,
        ];
    }
}
