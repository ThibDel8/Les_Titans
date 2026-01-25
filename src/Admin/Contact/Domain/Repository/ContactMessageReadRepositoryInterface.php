<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\Repository;

use App\Contact\Domain\Entity\ContactMessage;

interface ContactMessageReadRepositoryInterface
{
    /** @return ContactMessage[] */
    public function findAllOrderedByDate(): array;

    /** @return ContactMessage[] */
    public function findAllMessages(): array;

    /** @return ContactMessage[] */
    public function findUnreadContactMessages(): array;
}
