<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Domain\Enum;

enum EntityType: string
{
    case User = 'user';
    case Membership = 'membership';

    public function label(): string
    {
        return match ($this) {
            self::User => 'Membre',
            self::Membership => 'Demande d\'adhésion',
        };
    }
}
