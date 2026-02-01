<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\PublicApp\Contact\Domain\Repository\ContactMessageWriteRepositoryInterface;

readonly class ReadContactMessageHandler
{
    public function __construct(private ContactMessageWriteRepositoryInterface $contactMessageWriteRepository)
    {
    }

    public function handle(ContactMessage $contactMessage, User $reader): void
    {
        $contactMessage->saveAssignTo($reader);

        $this->contactMessageWriteRepository->save($contactMessage);
    }
}
