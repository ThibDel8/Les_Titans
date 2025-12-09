<?php

declare(strict_types=1);

namespace App\Handler\Contact;

use App\Repository\Contact\MessageRepository;
use App\DTO\Request\Contact\MessageCreationRequest;
use App\Entity\Contact\Message;

final class CreateMessageHandler
{
    public function __construct(private MessageRepository $messageRepository) {
    }

    public function handle(MessageCreationRequest $request): void
    {
        $message = Message::create(
            email: $request->email,
            subject: $request->subject,
            message: $request->message,
        );

        $this->messageRepository->save($message);

        // envoyer le message
    }
}
