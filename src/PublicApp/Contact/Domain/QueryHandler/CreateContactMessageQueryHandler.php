<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\QueryHandler;

use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\SharedKernel\Domain\Enum\Role;

readonly class CreateContactMessageQueryHandler
{
    public function __construct(private UserReadRepositoryInterface $userReadRepository)
    {
    }

    public function fetch(): array
    {
        $users = $this->userReadRepository->getBoardMembers();

        usort($users, function ($a, $b) {
            $roleHierarchy = [
                Role::Admin->value => 1,
                Role::President->value => 2,
                Role::VicePresident->value => 3,
                Role::Treasurer->value => 4,
                Role::Secretary->value => 5,
            ];
            $roleA = array_reduce($a->getRoles(), fn ($carry, $r) => min($carry, $roleHierarchy[$r] ?? 999), 999);
            $roleB = array_reduce($b->getRoles(), fn ($carry, $r) => min($carry, $roleHierarchy[$r] ?? 999), 999);

            return $roleA <=> $roleB;
        });

        return $users;
    }
}
