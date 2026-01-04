<?php

declare(strict_types=1);

namespace App\Handler\Contact;

use App\Repository\Contact\MessageRepository;
use App\DTO\Request\Contact\MessageCreationRequest;
use App\Entity\Contact\Message;
use App\Service\Contact\MessageContactService;

final class CreateMessageHandler
{
    public function __construct(
        private MessageRepository $messageRepository,
        private MessageContactService $messageContactService,
    ) {
    }

    public function handle(MessageCreationRequest $request): void
    {
        $message = Message::create(
            email: $request->email,
            subject: $request->subject,
            message: $request->message,
        );

        $this->messageRepository->save($message);

        $this->messageContactService->sendContactMessage($message);
    }
}
