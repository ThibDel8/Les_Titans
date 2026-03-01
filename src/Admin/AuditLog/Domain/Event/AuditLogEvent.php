<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Domain\Event;

use App\Admin\AuditLog\Domain\Enum\Action;
use App\Admin\AuditLog\Domain\Enum\EntityType;
use Symfony\Contracts\EventDispatcher\Event;

final class AuditLogEvent extends Event
{
    public function __construct(
        public string $authorId,
        public string $authorFullname,
        public string $authorEmail,
        public Action $action,
        public EntityType $entityType,
        public string $entityId,
        public ?string $message = null,
    ) {
    }
}
