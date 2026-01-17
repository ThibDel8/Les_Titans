<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\QueryHandler;

use App\Admin\User\Domain\Repository\UserRepository;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;

class ListUserQueryHandler
{
    public function __construct(private UserReadRepositoryInterface $userReadRepository)
    {
    }

    public function fetch(): array
    {
        $now = new \DateTimeImmutable('now');
        $users = $this->userReadRepository->findAllOrderedByFirstname();

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
