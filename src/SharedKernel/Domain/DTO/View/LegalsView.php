<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\DTO\View;

use App\Admin\User\Domain\Entity\User;

class LegalsView
{
    public function __construct(public User $president)
    {
    }

    public static function create(User $president): self
    {
        return new self(president: $president);
    }
}
