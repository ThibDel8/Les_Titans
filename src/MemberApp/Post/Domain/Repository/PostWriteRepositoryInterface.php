<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Repository;

use App\MemberApp\Post\Domain\Entity\Post;

interface PostWriteRepositoryInterface
{
    public function delete(Post $post, bool $flush = true): void;

    public function save(Post $post, bool $flush = true): void;
}
