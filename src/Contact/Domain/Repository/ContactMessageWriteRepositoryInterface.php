<?php

declare(strict_types=1);

namespace App\Contact\Domain\Repository;

use App\Contact\Domain\Entity\ContactMessage;

interface ContactMessageWriteRepositoryInterface
{
    public function delete(ContactMessage $contactMessage, bool $flush = true): void;

    public function save(ContactMessage $contactMessage, bool $flush = true): void;
}
