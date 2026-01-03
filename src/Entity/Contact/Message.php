<?php

declare(strict_types=1);

namespace App\Entity\Contact;

use App\Entity\Security\User;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Contact\MessageRepository;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table(name: "contact_messages")]
class Message
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', length: 36)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $subject;

    #[ORM\Column(type: Types::TEXT)]
    private string $message;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $isUnread;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $answerBy = null;

    public function __construct(string $email, string $subject, string $message)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;

        // Initialisation des valeurs par défaut
        $this->id = Uuid::v4();
        $this->isUnread = true;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUuid(): Uuid
    {
        return $this->id;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function isUnread(): bool
    {
        return $this->isUnread;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getAnswerBy(): ?string
    {
        return $this->answerBy;
    }

    public function markAsRead(): void
    {
        $this->isUnread = false;
    }

    public function markAsAnswerBy(string $name): void
    {
        $this->answerBy = $name;
    }

    public static function create(
        string $email,
        string $subject,
        string $message,
    ): self
    {
        return new self(
            email: $email,
            subject: $subject,
            message: $message,
        );
    }
}
