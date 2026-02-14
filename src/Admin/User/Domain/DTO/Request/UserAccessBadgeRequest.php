<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\DTO\Request;

use App\Admin\User\Domain\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UserAccessBadgeRequest
{
    #[Assert\Type('string')]
    #[Assert\Regex(
        pattern: '/^\d{10}$/',
        message: 'Le numéro de badge doit contenir exactement 10 chiffres.'
    )]
    public ?string $accessBadgeNumber = null;

    public static function fromEntity(User $user): self
    {
        $dto = new self();
        $dto->accessBadgeNumber = $user->getAccessBadgeNumber();

        return $dto;
    }
}
