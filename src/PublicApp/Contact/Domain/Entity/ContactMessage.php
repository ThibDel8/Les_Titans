<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\Entity;

use App\Admin\User\Domain\Entity\User;
use App\PublicApp\Contact\Domain\Enum\ContactMessageStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'contact_messages')]
class ContactMessage
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', length: 36)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $subject;

    #[ORM\Column(type: Types::TEXT)]
    private string $body;

    #[ORM\Column(enumType: ContactMessageStatus::class)]
    private ContactMessageStatus $status;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $assignedTo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $answer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $answeredBy = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $answeredAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $email,
        string $subject,
        string $body,
        ?string $id = null,
    ) {
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;

        // Initialisation des valeurs par défaut
        $this->id = $id ? Uuid::fromString($id) : Uuid::v4();
        $this->status = ContactMessageStatus::NEW;
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

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): ContactMessageStatus
    {
        return $this->status;
    }

    public function getAssignedTo(): ?User
    {
        return $this->assignedTo;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function getAnsweredBy(): ?User
    {
        return $this->answeredBy;
    }

    public function getAnsweredAt(): ?\DateTimeImmutable
    {
        return $this->answeredAt;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function saveAssignTo(User $boardMember): void
    {
        if (ContactMessageStatus::NEW !== $this->status) {
            return;
        }

        $this->assignedTo = $boardMember;
        $this->status = ContactMessageStatus::IN_PROGRESS;
    }

    public function saveUnread(): void
    {
        if (ContactMessageStatus::IN_PROGRESS !== $this->status) {
            return;
        }

        $this->assignedTo = null;
        $this->status = ContactMessageStatus::NEW;
    }

    public function saveAnswer(string $answer, User $boardMember): void
    {
        if (ContactMessageStatus::IN_PROGRESS !== $this->status) {
            return;
        }

        if (null === $this->assignedTo) {
            return;
        }

        $this->answer = \trim($answer);
        $this->answeredBy = $boardMember;
        $this->answeredAt = new \DateTimeImmutable();
        $this->status = ContactMessageStatus::ANSWERED;
    }

    public static function create(
        string $email,
        string $subject,
        string $body,
        ?string $id = null,
    ): self {
        return new self(
            email: \strtolower($email),
            subject: \ucfirst(\strtolower(\trim($subject))),
            body: \trim($body),
            id: $id,
        );
    }
}
