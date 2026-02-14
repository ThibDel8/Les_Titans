<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Post\Domain\DTO\Request\CreateCommentRequest;
use App\MemberApp\Post\Domain\Entity\Comment;
use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Repository\CommentWriteRepositoryInterface;

readonly class CreateCommentHandler
{
    public function __construct(private CommentWriteRepositoryInterface $commentWriteRepository)
    {
    }

    public function handle(Post $post, User $author, CreateCommentRequest $createCommentRequest): void
    {
        $comment = Comment::create(
            post: $post,
            author: $author,
            text: $createCommentRequest->text,
        );

        $this->commentWriteRepository->save($comment);
    }
}
