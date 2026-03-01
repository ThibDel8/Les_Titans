<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Domain\Repository;

use App\Admin\AuditLog\Domain\Entity\AuditLog;

interface AuditLogWriteRepositoryInterface
{
    public function save(AuditLog $auditLog, bool $flush = true): void;
}
