<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Domain\Repository;

use App\Admin\AuditLog\Domain\Entity\AuditLog;

interface AuditLogReadRepositoryInterface
{
    /** @return AuditLog[] */
    public function getLatestLogs(int $limit = 20): array;
}
