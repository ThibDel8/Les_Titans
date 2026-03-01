<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Infrastructure\Doctrine\Repository;

use App\Admin\AuditLog\Domain\Repository\AuditLogWriteRepositoryInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;
use Doctrine\ORM\EntityManagerInterface;

class AuditLogWriteRepository extends AbstractWriteRepository implements AuditLogWriteRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
