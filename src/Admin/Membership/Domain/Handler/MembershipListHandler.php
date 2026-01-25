<?php

declare(strict_types=1);

namespace App\Admin\Membership\Domain\Handler;

use App\SharedKernel\Membership\Domain\Repository\MembershipReadRepositoryInterface;

final class MembershipListHandler
{
    public function __construct(private MembershipReadRepositoryInterface $membershipReadRepository)
    {
    }

    public function handle(): array
    {
        return $this->membershipReadRepository->findAllOrdererByCreatedAt();
    }
}
