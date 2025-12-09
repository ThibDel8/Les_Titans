<?php

declare(strict_types=1);

namespace App\QueryHandler\User;

use App\Entity\User\User;
use App\Repository\Security\UserRepository;

class ListUserQueryHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function fetch(): array
    {
        return $this->userRepository->findAllByRoleOrdedr();
    }
}
