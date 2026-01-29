<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Repository;

use App\MemberApp\Post\Domain\Entity\Post;

interface PostReadRepositoryInterface
{
    /** @return Post[] */
    public function findAllPosts(): array;
}
