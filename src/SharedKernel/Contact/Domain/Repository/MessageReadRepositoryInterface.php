<?php

declare(strict_types=1);

namespace App\SharedKernel\Contact\Domain\Repository;

interface MessageReadRepositoryInterface
{
    public function findAllOrderedByDate(): array;

    public function findAllMessages(): array;
}
