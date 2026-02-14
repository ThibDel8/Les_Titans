<?php

declare(strict_types=1);

namespace App\Admin\Membership\Domain\DTO\Request;

use App\MemberApp\Membership\Domain\Entity\Membership;
use Symfony\Component\Validator\Constraints as Assert;

class ValidateMembershipRequest
{
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Assert\GreaterThan(
        value: 'today',
        message: "Le certificat médical doit être plus ancien qu'aujourd'hui."
    )]
    public ?\DateTimeImmutable $medicalCertificateExpiry = null;

    #[Assert\Type('bool')]
    public ?bool $accessBadgeDeposit = null;

    #[Assert\Type('bool')]
    public ?bool $annualMembershipFee = null;

    public static function fromEntity(Membership $membership): self
    {
        $dto = new self();
        $dto->medicalCertificateExpiry = $membership->getMedicalCertificateExpiry();
        $dto->accessBadgeDeposit = (bool) $membership->getAccessBadgeDeposit();
        $dto->annualMembershipFee = (bool) $membership->getAnnualMembershipFee();

        return $dto;
    }
}
