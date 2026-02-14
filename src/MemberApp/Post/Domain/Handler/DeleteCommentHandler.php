<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Handler;

use App\MemberApp\Post\Domain\Entity\Comment;
use App\MemberApp\Post\Domain\Repository\CommentWriteRepositoryInterface;

readonly class DeleteCommentHandler
{
    public function __construct(private CommentWriteRepositoryInterface $commentWriteRepository)
    {
    }

    public function handle(Comment $comment): void
    {
        $this->commentWriteRepository->delete($comment);
    }
}
