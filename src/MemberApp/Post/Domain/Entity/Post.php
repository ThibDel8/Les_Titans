<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Entity;

use App\Admin\User\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\MemberApp\Post\Domain\Entity\Comment;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'posts')]
class Post
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', length: 36)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $author;

    #[ORM\Column(type: Types::TEXT)]
    private string $text;

    #[ORM\Column(type: Types::JSON)]
    private array $attachments;

    #[ORM\Column(type: Types::JSON)]
    private array $linkPreview;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $comments;

    public function __construct(
        ?User $author,
        string $text,
        array $attachments = [],
        array $linkPreview = [],
    ) {
        $this->author = $author;
        $this->text = $text;
        $this->attachments = $attachments;
        $this->linkPreview = $linkPreview;

        // Initialisation des valeurs par défaut
        $this->id = Uuid::v4();
        $this->comments = new ArrayCollection();
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function getLinkPreview(): array
    {
        return $this->linkPreview;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public static function create(
        ?User $author,
        string $text,
        array $attachments = [],
        array $linkPreview = [],
    ): self {
        return new self(
            $author,
            $text,
            $attachments,
            $linkPreview,
        );
    }
}
