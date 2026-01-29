<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\QueryHandler;

use App\MemberApp\Post\Domain\Repository\PostReadRepositoryInterface;

readonly class ListPostQueryHandler
{
    public function __construct(private PostReadRepositoryInterface $postReadRepository)
    {
    }

    public function fetch(): array
    {
        return $this->postReadRepository->findAllPosts();
    }
}
