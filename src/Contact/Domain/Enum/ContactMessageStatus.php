<?php

declare(strict_types=1);

namespace App\Contact\Domain\Enum;

enum ContactMessageStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case ANSWERED = 'answered';
    case ARCHIVED = 'archived';
}
