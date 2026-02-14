<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Repository;

use App\MemberApp\Post\Domain\Entity\Comment;

interface CommentWriteRepositoryInterface
{
    public function delete(Comment $comment, bool $flush = true): void;

    public function save(Comment $comment, bool $flush = true): void;
}
