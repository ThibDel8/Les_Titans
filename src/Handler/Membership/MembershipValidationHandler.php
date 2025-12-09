<?php

declare(strict_types=1);

namespace App\Handler\Membership;

use App\Entity\Membership\Membership;
use App\Repository\Membership\MembershipRepository;
use App\DTO\Request\Membership\MembershipValidationRequest;

final class MembershipValidationHandler
{
    public function __construct(private MembershipRepository $repository)
    {
    }

    public function handle(Membership $membership, MembershipValidationRequest $request): void
    {
        $membership->updateValidation($request);

        $this->repository->save($membership);
    }
}
