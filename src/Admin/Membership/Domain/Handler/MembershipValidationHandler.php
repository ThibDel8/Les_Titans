<?php

declare(strict_types=1);

namespace App\Admin\Membership\Domain\Handler;

use App\SharedKernel\Membership\Domain\Entity\Membership;
use App\Admin\Membership\Domain\DTO\Request\MembershipValidationRequest;
use App\SharedKernel\Membership\Domain\Repository\MembershipWriteRepositoryInterface;

final class MembershipValidationHandler
{
    public function __construct(private MembershipWriteRepositoryInterface $membershipWriteRepository)
    {
    }

    public function handle(Membership $membership, MembershipValidationRequest $request): void
    {
        $membership->updateValidation($request);

        $this->membershipWriteRepository->save($membership);
    }
}
