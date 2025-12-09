<?php

declare(strict_types=1);

namespace App\DTO\Request\Member;

use App\Entity\Member\Member;
use Symfony\Component\Validator\Constraints as Assert;

class MemberAccessBadgeRequest
{
    #[Assert\Type("string")]
    #[Assert\Regex(
    pattern: '/^\d{10}$/',
    message: 'Le numéro de badge doit contenir exactement 10 chiffres.'
)]
    public ?string $accessBadgeNumber = null;

    public static function fromEntity(Member $member): self
    {
        $dto = new self();
        $dto->accessBadgeNumber = $member->getAccessBadgeNumber();

        return $dto;
    }
}
