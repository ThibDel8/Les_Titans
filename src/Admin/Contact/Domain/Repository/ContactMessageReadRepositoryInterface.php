<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\Repository;

interface ContactMessageReadRepositoryInterface
{
    public function findAllOrderedByDate(): array;

    public function findAllMessages(): array;
}
