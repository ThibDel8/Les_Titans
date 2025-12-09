<?php

declare(strict_types=1);

namespace App\Entity\Security;

use App\Entity\Member\Member;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Security\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', length: 36)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $password;

    #[ORM\Column(type: Types::JSON)]
    private array $roles;

    #[ORM\OneToOne(targetEntity: Member::class, inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: false)]
    private Member $member;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    private ?string $passwordSetupToken = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $passwordSetupTokenExpiresAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Member $member,
        array $roles,
        string $email,
        ?string $password = null,
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
        $this->member = $member;

        // Initialisation des valeurs par défaut
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTimeImmutable('now');
        $this->passwordSetupToken = bin2hex(random_bytes(32));
        $this->passwordSetupTokenExpiresAt = new \DateTimeImmutable('+24 hours');
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getPasswordSetupToken(): ?string
    {
        return $this->passwordSetupToken;
    }

    public function setPasswordSetupToken(?string $token): self
    {
        $this->passwordSetupToken = $token;
        return $this;
    }

    public function getPasswordSetupTokenExpiresAt(): ?\DateTimeImmutable
    {
        return $this->passwordSetupTokenExpiresAt;
    }

    public function setPasswordSetupTokenExpiresAt(?\DateTimeImmutable $expiresAt): self
    {
        $this->passwordSetupTokenExpiresAt = $expiresAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function setPassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
    }


    public static function create(
        Member $member,
        array $roles,
        string $email,
    ): self
    {
        return new self(
            member: $member,
            roles: $roles,
            email: $email,
        );
    }
}
