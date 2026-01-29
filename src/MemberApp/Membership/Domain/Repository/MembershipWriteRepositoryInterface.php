<?php

declare(strict_types=1);

namespace App\MemberApp\Membership\Domain\Repository;

use App\MemberApp\Membership\Domain\Entity\Membership;

interface MembershipWriteRepositoryInterface
{
    public function delete(Membership $membership, bool $flush = true): void;

    public function save(Membership $membership, bool $flush = true): void;
}
