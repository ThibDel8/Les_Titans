<?php

declare(strict_types=1);

namespace App\QueryHandler\Home;

use App\Entity\Contact\Message;
use App\Repository\Member\MemberRepository;
use App\Repository\Security\UserRepository;
use App\Repository\Contact\MessageRepository;
use App\Repository\Membership\MembershipRepository;

class HomeQueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private MessageRepository $messageRepository,
        private MembershipRepository $membershipRepository,
    ) {
    }

    public function fetch(): array
    {
        $users = $this->userRepository->findAll();
        $messages = $this->messageRepository->findAll();
        $memberships = $this->membershipRepository->findAll();

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
