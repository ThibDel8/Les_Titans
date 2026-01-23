<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Domain\QueryHandler;

use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\Admin\Contact\Domain\Repository\ContactMessageReadRepositoryInterface;
use App\SharedKernel\Membership\Domain\Repository\MembershipReadRepositoryInterface;

class DashboardQueryHandler
{
    public function __construct(
        private UserReadRepositoryInterface $userReadRepository,
        private ContactMessageReadRepositoryInterface $contactMessageReadRepository,
        private MembershipReadRepositoryInterface $membershipReadRepository,
    ) {
    }

    public function fetch(): array
    {
        $users = $this->userReadRepository->findAllUsers();
        $messages = $this->contactMessageReadRepository->findAllMessages();
        $memberships = $this->membershipReadRepository->findAllMemberships();

        return [
            'nbUsers' => \count($users),
            'nbUnreadMessages' => \count($messages),
            'nbMemberships' => \count($memberships),
        ];
    }
}
