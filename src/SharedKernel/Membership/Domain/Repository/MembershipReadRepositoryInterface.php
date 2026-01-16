<?php

declare(strict_types=1);

namespace App\SharedKernel\Membership\Domain\Repository;

interface MembershipReadRepositoryInterface
{
    public function findAllOrdererByCreatedAt(): array;

    public function findAllMemberships(): array;
}
