<?php

declare(strict_types=1);

namespace App\Contact\Domain\Repository;

use App\Contact\Domain\Entity\ContactMessage;

interface ContactMessageWriteRepositoryInterface
{
    public function save(ContactMessage $message, bool $flush = true): void;
}
