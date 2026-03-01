<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Domain\Subscriber;

use App\Admin\AuditLog\Domain\Entity\AuditLog;
use App\Admin\AuditLog\Domain\Event\AuditLogEvent;
use App\Admin\AuditLog\Domain\Repository\AuditLogWriteRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class AuditLogSubscriber implements EventSubscriberInterface
{
    public function __construct(private AuditLogWriteRepositoryInterface $auditLogWriteRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AuditLogEvent::class => 'onAuditLogEvent',
        ];
    }

    public function onAuditLogEvent(AuditLogEvent $event): void
    {
        $auditLog = AuditLog::create(
            authorId: $event->authorId,
            authorFullname: $event->authorFullname,
            authorEmail: $event->authorEmail,
            action: $event->action,
            entityType: $event->entityType,
            entityId: $event->entityId,
            message: $event->message,
        );

        $this->auditLogWriteRepository->save($auditLog);
    }
}
