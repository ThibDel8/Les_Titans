<?php

declare(strict_types=1);

namespace App\Contact\Domain\Handler;

use App\Contact\Domain\Entity\ContactMessage;
use App\Contact\Domain\Service\ContactMessageContactService;
use App\Contact\Domain\DTO\Request\ContactMessageCreationRequest;
use App\Contact\Domain\Repository\ContactMessageWriteRepositoryInterface;

final class CreateContactMessageHandler
{
    public function __construct(
        private ContactMessageContactService $messageContactService,
        private ContactMessageWriteRepositoryInterface $messageWriteRepository,
    ) {
    }

    public function handle(ContactMessageCreationRequest $request): void
    {
        $message = ContactMessage::create(
            email: $request->email,
            subject: $request->subject,
            body: $request->body,
        );

        $this->messageWriteRepository->save($message);

        $this->messageContactService->sendContactMessage($message);
    }
}
