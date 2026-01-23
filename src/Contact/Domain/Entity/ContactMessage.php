<?php

declare(strict_types=1);

namespace App\Contact\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Contact\Domain\Enum\ContactMessageStatus;

#[ORM\Entity]
#[ORM\Table(name: "contact_messages")]
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

    #[ORM\Column(type: 'uuid', length: 36, nullable: true)]
    private ?Uuid $assignedTo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $answer = null;

    #[ORM\Column(type: 'uuid', length: 36, nullable: true)]
    private ?Uuid $answeredBy = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $answeredAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $email,
        string $subject,
        string $body,
    ) {
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;

        // Initialisation des valeurs par défaut
        $this->id = Uuid::v4();
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

    public function getAssignedTo(): ?Uuid
    {
        return $this->assignedTo;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function getAnsweredBy(): ?Uuid
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

    public function assignTo(Uuid $adminId): void
    {
        if ($this->status !== ContactMessageStatus::NEW) {
            throw new \DomainException('Contact message already assigned.');
        }

        $this->assignedTo = $adminId;
        $this->status = ContactMessageStatus::IN_PROGRESS;
    }

    public function answer(string $answer, Uuid $adminId): void
    {
        if ($this->status !== ContactMessageStatus::IN_PROGRESS) {
            throw new \DomainException('Contact message not in progress.');
        }

        if ($this->assignedTo === null || !$this->assignedTo->equals($adminId)) {
            throw new \DomainException('Only assigned admin can answer.');
        }

        $this->answer = \trim($answer);
        $this->answeredBy = $adminId;
        $this->answeredAt = new \DateTimeImmutable();
        $this->status = ContactMessageStatus::ANSWERED;
    }

    public function archive(): void
    {
        if ($this->status !== ContactMessageStatus::ANSWERED) {
            throw new \DomainException('Only answered messages can be archived.');
        }

        $this->status = ContactMessageStatus::ARCHIVED;
    }

    public static function create(
        string $email,
        string $subject,
        string $body,
    ): self
    {
        return new self(
            email: \strtolower($email),
            subject: \trim(\ucfirst(\strtolower($subject))),
            body: \trim($body),
        );
    }
}
