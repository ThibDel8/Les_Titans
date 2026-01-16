<?php

declare(strict_types=1);

namespace App\Admin\Membership\Domain\DTO\Request;

use App\SharedKernel\Membership\Domain\Entity\Membership;
use Symfony\Component\Validator\Constraints as Assert;

class MembershipValidationRequest
{
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Assert\GreaterThan("today", message: "Le certificat médical doit être plus ancien qu'aujourd'hui.")]
    public ?\DateTimeImmutable $medicalCertificateExpiry = null;

    #[Assert\Type("integer")]
    #[Assert\PositiveOrZero(message: "Le dépôt du badge doit être positif ou nul.")]
    public ?int $accessBadgeDeposit = null;

    #[Assert\Type("integer")]
    #[Assert\PositiveOrZero(message: "La cotisation annuelle doit être positive ou nulle.")]
    public ?int $annualMembershipFee = null;

    public static function fromEntity(Membership $membership): self
    {
        $dto = new self();
        $dto->medicalCertificateExpiry = $membership->getMedicalCertificateExpiry();
        $dto->accessBadgeDeposit = $membership->getAccessBadgeDeposit();
        $dto->annualMembershipFee = $membership->getAnnualMembershipFee();

        return $dto;
    }
}
