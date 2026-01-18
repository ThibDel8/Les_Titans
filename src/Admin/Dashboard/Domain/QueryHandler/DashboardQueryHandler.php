<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Domain\QueryHandler;

use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\SharedKernel\Contact\Domain\Entity\Message;
use App\SharedKernel\Contact\Domain\Repository\MessageReadRepositoryInterface;
use App\SharedKernel\Membership\Domain\Repository\MembershipReadRepositoryInterface;

class DashboardQueryHandler
{
    public function __construct(
        private UserReadRepositoryInterface $userReadRepository,
        private MessageReadRepositoryInterface $messageReadRepository,
        private MembershipReadRepositoryInterface $membershipReadRepository,
    ) {
    }

    public function fetch(): array
    {
        $users = $this->userReadRepository->findAllUsers();
        $messages = $this->messageReadRepository->findAllMessages();
        $memberships = $this->membershipReadRepository->findAllMemberships();

        return [
            'nbUsers' => \count($users),
            'nbUnreadMessages' => $this->countUnreadMessages($messages),
            'nbMemberships' => \count($memberships),
        ];
    }

    private function countUnreadMessages(array $messages): int
    {
        $unreadMessages = [];
        /** @var Message $message */
        foreach ($messages as $message) {
            if (false === $message->isUnread()) {
                continue;
            }

            $unreadMessages[] = $message;
        }

        return \count($unreadMessages);
    }
}
