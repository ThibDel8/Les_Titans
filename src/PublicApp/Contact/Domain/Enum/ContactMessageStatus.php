<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\Enum;

enum ContactMessageStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case ANSWERED = 'answered';

    public function label(): string
    {
        return match($this) {
            self::NEW => 'Nouveau',
            self::IN_PROGRESS => 'Lu',
            self::ANSWERED => 'Répondu',
        };
    }
}
