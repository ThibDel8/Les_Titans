<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\Handler;

use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\PublicApp\Contact\Domain\Repository\ContactMessageWriteRepositoryInterface;

final class DeleteContactMessageHandler
{
    public function __construct(
        private ContactMessageWriteRepositoryInterface $contactMessageWriteRepository,
    ) {
    }

    public function handle(ContactMessage $contactMessage): void
    {
        $this->contactMessageWriteRepository->delete($contactMessage);
    }
}
