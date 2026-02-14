<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCommentRequest
{
    #[Assert\NotBlank(message: 'Le commentaire à besoin d\'un texte.')]
    public ?string $text;
}
