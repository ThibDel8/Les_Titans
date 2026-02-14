<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Post\Domain\DTO\Request\CreatePostRequest;
use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Repository\PostWriteRepositoryInterface;

readonly class CreatePostHandler
{
    public function __construct(private PostWriteRepositoryInterface $postWriteRepository)
    {
    }

    public function handle(CreatePostRequest $createPostRequest, User $author): void
    {
        $post = Post::create(
            author: $author,
            text: $createPostRequest->text,
            attachments: $createPostRequest->attachments ?? [],
            linkPreview: $createPostRequest->linkPreview ?? [],
        );

        $this->postWriteRepository->save($post);
    }
}
