<?php

declare(strict_types=1);

namespace App\MemberApp\Membership\Domain\Repository;

interface MembershipReadRepositoryInterface
{
    public function findAllOrdererByCreatedAt(): array;

    public function findAllMemberships(): array;
}
