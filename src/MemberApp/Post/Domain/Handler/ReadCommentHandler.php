<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Handler;

use App\MemberApp\Post\Domain\Entity\Post;

readonly class ReadCommentHandler
{
    public function handle(Post $post): array
    {
        $comments = $post->getComments()->toArray();

        usort($comments, function($a, $b) {
            return $a->getCreatedAt() <=> $b->getCreatedAt();
        });

        return $comments;
    }
}
