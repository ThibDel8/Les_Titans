<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\Handler;

use App\PublicApp\Contact\Domain\DTO\Request\MessageCreationRequest;
use App\SharedKernel\Contact\Domain\Entity\Message;
use App\PublicApp\Contact\Domain\Service\MessageContactService;
use App\SharedKernel\Contact\Domain\Repository\MessageWriteRepositoryInterface;

final class CreateMessageHandler
{
    public function __construct(
        private MessageContactService $messageContactService,
        private MessageWriteRepositoryInterface $messageWriteRepository,
    ) {
    }

    public function handle(MessageCreationRequest $request): void
    {
        $message = Message::create(
            email: $request->email,
            subject: $request->subject,
            message: $request->message,
        );

        $this->messageWriteRepository->save($message);

        $this->messageContactService->sendContactMessage($message);
    }
}
