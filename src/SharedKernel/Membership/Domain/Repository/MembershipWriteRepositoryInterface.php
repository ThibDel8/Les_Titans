<?php

declare(strict_types=1);

namespace App\SharedKernel\Membership\Domain\Repository;

use App\SharedKernel\Membership\Domain\Entity\Membership;

interface MembershipWriteRepositoryInterface
{
    public function delete(Membership $membership, bool $flush = true): void;

    public function save(Membership $membership, bool $flush = true): void;
}
