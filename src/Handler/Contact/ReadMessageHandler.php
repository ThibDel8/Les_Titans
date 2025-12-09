<?php

declare(strict_types=1);

namespace App\Handler\Contact;

use App\Entity\Contact\Message;
use App\Repository\Contact\MessageRepository;

class ReadMessageHandler
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }

    public function handle(Message $message): Message
    {
        if ($message->isUnread()) {
            $message->markAsRead();
            $this->messageRepository->save($message);
        }

        return $message;
    }
}
