<?php

declare(strict_types=1);

namespace App\Admin\Membership\Domain\Handler;

use App\Admin\Membership\Domain\DTO\Request\ValidateMembershipRequest;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\MemberApp\Membership\Domain\Repository\MembershipWriteRepositoryInterface;

final readonly class ValidateMembershipHandler
{
    public function __construct(private MembershipWriteRepositoryInterface $membershipWriteRepository)
    {
    }

    public function handle(Membership $membership, ValidateMembershipRequest $request): void
    {
        $membership->updateValidation(
            annualMembershipFee: true === $request->annualMembershipFee ? 50 : null,
            accessBadgeDeposit: true === $request->accessBadgeDeposit ? 10 : null,
            medicalCertificateExpiry: $request->medicalCertificateExpiry,
        );

        $this->membershipWriteRepository->save($membership);
    }
}
