<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;
class CreatePostRequest
{
    #[Assert\NotBlank(message: 'La publication à besoin d\'un texte.')]
    public ?string $text;

    public ?array $attachments;

    public ?array $linkPreview;
}
