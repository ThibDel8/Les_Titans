<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\QueryHandler;

use App\Admin\Contact\Domain\Repository\ContactMessageReadRepositoryInterface;

class ListContactMessageQueryHandler
{
    public function __construct(private ContactMessageReadRepositoryInterface $contactMessageReadRepository)
    {
    }

    public function fetch()
    {
        return $this->contactMessageReadRepository->findAllOrderedByDate();
    }
}
