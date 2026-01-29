<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ContactMessageCreationRequest
{
    #[Assert\NotBlank(message: 'L\'email doit être renseigné.')]
    #[Assert\Email(message: 'Ceci n\'est pas un email valide.')]
    #[Assert\Length(max: 255)]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'Le sujet doit être renseigné.')]
    public ?string $subject = null;

    #[Assert\NotBlank(message: 'Le message doit être renseigné.')]
    public ?string $body = null;
}
