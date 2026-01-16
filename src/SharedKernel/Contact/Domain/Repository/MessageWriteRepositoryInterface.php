<?php

declare(strict_types=1);

namespace App\SharedKernel\Contact\Domain\Repository;

use App\SharedKernel\Contact\Domain\Entity\Message;

interface MessageWriteRepositoryInterface
{
    public function save(Message $message, bool $flush = true): void;
}
