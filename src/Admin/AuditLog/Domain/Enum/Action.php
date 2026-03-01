<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Domain\Enum;

enum Action: string
{
    case Create = 'create';
    case Update = 'update';
    case Delete = 'delete';

    public function logLabel(): string
    {
        return match ($this) {
            self::Create => 'créé',
            self::Update => 'modifié',
            self::Delete => 'supprimé',
        };
    }
}
