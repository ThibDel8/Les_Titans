<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\DTO\Request;

use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use Symfony\Component\Validator\Constraints as Assert;

class AnswerContactMessageRequest
{
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    public ?string $answer = null;

    public static function fromEntity(ContactMessage $contactMessage): self
    {
        $dto = new self();
        $dto->answer = $contactMessage->getAnswer();

        return $dto;
    }
}
