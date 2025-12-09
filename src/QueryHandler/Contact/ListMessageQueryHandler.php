<?php

declare(strict_types=1);

namespace App\QueryHandler\Contact;

use App\Repository\Contact\MessageRepository;

class ListMessageQueryHandler
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }

    public function fetch()
    {
        return $this->messageRepository->findAllOrderedByDate();
    }
}
