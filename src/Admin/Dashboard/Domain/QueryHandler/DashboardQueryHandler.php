<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Domain\QueryHandler;

use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\Admin\Contact\Domain\Repository\ContactMessageReadRepositoryInterface;
use App\Admin\Dashboard\Domain\DataCounter\DataCounter;
use App\SharedKernel\Membership\Domain\Repository\MembershipReadRepositoryInterface;

class DashboardQueryHandler
{
    public function __construct(
        private UserReadRepositoryInterface $userReadRepository,
        private ContactMessageReadRepositoryInterface $contactMessageReadRepository,
        private MembershipReadRepositoryInterface $membershipReadRepository,
    ) {
    }

    public function fetch(): DataCounter
    {
        $users = $this->userReadRepository->findAllUsers();
        $messages = $this->contactMessageReadRepository->findUnreadContactMessages();
        $memberships = $this->membershipReadRepository->findAllMemberships();

        return DataCounter::create(
            nbUsers: \count($users),
            nbContactMessages: \count($messages),
            nbMemberships: \count($memberships),
        );
    }
}
