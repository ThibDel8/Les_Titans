<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Entity;

use App\Admin\User\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'post_comments')]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', length: 36)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private Post $post;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $author;

    #[ORM\Column(type: Types::TEXT)]
    private string $text;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Post $post,
        ?User $author,
        string $text,
    ) {
        $this->post = $post;
        $this->author = $author;
        $this->text = $text;

        // Initialisation des valeurs par défaut
        $this->id = Uuid::v4();
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

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public static function create(
        Post $post,
        ?User $author,
        string $text,
    ): self {
        return new self(
            $post,
            $author,
            $text,
        );
    }
}
