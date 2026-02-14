<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Handler;

use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Repository\PostWriteRepositoryInterface;

readonly class DeletePostHandler
{
    public function __construct(private PostWriteRepositoryInterface $postWriteRepository)
    {
    }

    public function handle(Post $post): void
    {
        $this->postWriteRepository->delete($post);
    }
}
