<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\QueryHandler;

use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;

readonly class CreateContactMessageQueryHandler
{
    public function __construct(private UserReadRepositoryInterface $userReadRepository)
    {
    }

    public function fetch(): array
    {
        return $this->userReadRepository->getBoardMembers();
    }
}
