<?php

declare(strict_types=1);

namespace App\Admin\AuditLog\Domain\Entity;

use App\Admin\AuditLog\Domain\Enum\Action;
use App\Admin\AuditLog\Domain\Enum\EntityType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
final class AuditLog
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $occurredAt;

    #[ORM\Column(length: 36)]
    private string $authorId;

    #[ORM\Column(length: 100)]
    private string $authorFullname;

    #[ORM\Column(length: 180)]
    private string $authorEmail;

    #[ORM\Column(enumType: Action::class)]
    private Action $action;

    #[ORM\Column(enumType: EntityType::class)]
    private EntityType $entityType;

    #[ORM\Column(length: 36)]
    private string $entityId;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message;

    public function __construct(
        string $authorId,
        string $authorFullname,
        string $authorEmail,
        Action $action,
        EntityType $entityType,
        string $entityId,
        ?string $message = null,
    ) {
        $this->authorId = $authorId;
        $this->authorFullname = $authorFullname;
        $this->authorEmail = $authorEmail;
        $this->action = $action;
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->message = $message;

        // Initialisation des valeurs par défaut
        $this->occurredAt = new \DateTimeImmutable();
        $this->id = Uuid::v7();
    }

    public function getUuid(): Uuid
    {
        return $this->id;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getOccurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getAuthorFullname(): string
    {
        return $this->authorFullname;
    }

    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    public function getEntityType(): EntityType
    {
        return $this->entityType;
    }

    public function getEntityId(): string
    {
        return $this->entityId;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public static function create(
        string $authorId,
        string $authorFullname,
        string $authorEmail,
        Action $action,
        EntityType $entityType,
        string $entityId,
        ?string $message = null,
    ): self {
        return new self(
            authorId: $authorId,
            authorFullname: $authorFullname,
            authorEmail: $authorEmail,
            action: $action,
            entityType: $entityType,
            entityId: $entityId,
            message: $message,
        );
    }
}
