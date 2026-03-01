<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Infrastructure\Doctrine\Repository;

use App\Admin\AuditLog\Domain\Entity\AuditLog;
use App\Admin\AuditLog\Domain\Repository\AuditLogReadRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

readonly class AuditLogReadRepository implements AuditLogReadRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function getLatestLogs(int $limit = 20): array
    {
        return $this->manager->getRepository(AuditLog::class)->findBy([], ['occurredAt' => 'DESC'], $limit);
    }
}
