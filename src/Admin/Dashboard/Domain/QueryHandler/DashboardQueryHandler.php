<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Domain\QueryHandler;

use App\Admin\AuditLog\Domain\Repository\AuditLogReadRepositoryInterface;
use App\Admin\Contact\Domain\Repository\ContactMessageReadRepositoryInterface;
use App\Admin\Dashboard\Domain\DTO\DashboardData;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\MemberApp\Membership\Domain\Repository\MembershipReadRepositoryInterface;

readonly class DashboardQueryHandler
{
    public function __construct(
        private UserReadRepositoryInterface $userReadRepository,
        private AuditLogReadRepositoryInterface $auditLogReadRepository,
        private MembershipReadRepositoryInterface $membershipReadRepository,
        private ContactMessageReadRepositoryInterface $contactMessageReadRepository,
    ) {
    }

    public function fetch(): DashboardData
    {
        $users = $this->userReadRepository->findAllUsers();
        $memberships = $this->membershipReadRepository->findAllMemberships();
        $messages = $this->contactMessageReadRepository->findUnreadContactMessages();
        $logs = $this->auditLogReadRepository->getLatestLogs();

        return DashboardData::create(
            nbUsers: \count($users),
            nbContactMessages: \count($messages),
            nbMemberships: \count($memberships),
            logs: $logs,
        );
    }
}
