<?php

declare(strict_types=1);

namespace App\Admin\Membership\Domain\QueryHandler;

use App\MemberApp\Membership\Domain\Repository\MembershipReadRepositoryInterface;

final readonly class ListMembershipQuery
{
    public function __construct(private MembershipReadRepositoryInterface $membershipReadRepository)
    {
    }

    public function fetch(): array
    {
        return $this->membershipReadRepository->findAllOrdererByCreatedAt();
    }
}
