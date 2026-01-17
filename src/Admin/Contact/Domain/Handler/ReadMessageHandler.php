<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\Handler;

use App\SharedKernel\Contact\Domain\Entity\Message;
use App\SharedKernel\Contact\Domain\Repository\MessageWriteRepositoryInterface;

class ReadMessageHandler
{
    public function __construct(private MessageWriteRepositoryInterface $messageWriteRepository)
    {
    }

    public function handle(Message $message): Message
    {
        if ($message->isUnread()) {
            $message->markAsRead();
            $this->messageWriteRepository->save($message);
        }

        return $message;
    }
}
