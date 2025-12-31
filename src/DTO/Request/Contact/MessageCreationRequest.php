<?php

declare(strict_types=1);

namespace App\DTO\Request\Contact;

use App\Entity\Contact\Message;
use Symfony\Component\Validator\Constraints as Assert;

class MessageCreationRequest
{
    #[Assert\NotBlank(message: 'L\'email doit être renseigné.')]
    #[Assert\Email(message: 'Ceci n\'est pas un email valide.')]
    public ?string $email = null;

    public ?string $subject = null;

    public ?string $message = null;
}
