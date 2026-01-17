<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\QueryHandler;

use App\SharedKernel\Contact\Domain\Repository\MessageReadRepositoryInterface;

class ListMessageQueryHandler
{
    public function __construct(private MessageReadRepositoryInterface $messageReadRepository)
    {
    }

    public function fetch()
    {
        return $this->messageReadRepository->findAllOrderedByDate();
    }
}
