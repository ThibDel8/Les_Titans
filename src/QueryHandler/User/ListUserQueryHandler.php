<?php

declare(strict_types=1);

namespace App\QueryHandler\User;

use App\Repository\Security\UserRepository;

class ListUserQueryHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function fetch(): array
    {
        $now = new \DateTimeImmutable('now');
        $users = $this->userRepository->findBy([], ['firstname' => 'ASC']);

        $validMembers = [];
        $invalidMembers = [];
        /** @var User $user */
        foreach ($users as $user) {
            if ($user->isValid($now)) {
                $validMembers[] = $user;
            } else {
                $invalidMembers[] = $user;
            }
        }

        return [
            'validMembers' => $validMembers,
            'invalidMembers' => $invalidMembers,
        ];
    }
}
