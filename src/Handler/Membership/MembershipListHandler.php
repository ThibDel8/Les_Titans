<?php

declare(strict_types=1);

namespace App\Handler\Membership;

use App\Repository\Membership\MembershipRepository;

final class MembershipListHandler
{
    public function __construct(private MembershipRepository $repository) {}

    public function handle(): array
    {
        return $this->repository->findBy([], ['createdAt' => 'DESC']);
    }
}
