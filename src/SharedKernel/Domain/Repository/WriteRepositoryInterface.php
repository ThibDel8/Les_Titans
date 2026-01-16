<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Repository;

interface WriteRepositoryInterface
{
    public function save(object $entity, bool $flush = true): void;

    public function delete(object $entity, bool $flush = true): void;

    public function saveBulk(iterable $entities, int $batchSize = 50): void;

    public function deleteBulk(iterable $entities, int $batchSize = 50): void;
}
