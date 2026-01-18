<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Entity;

use App\SharedKernel\Domain\Enum\Role;
use Doctrine\DBAL\Types\Types;
use App\SharedKernel\Domain\Enum\Gender;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', length: 36)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $profileImage = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $lastname;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $firstname;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $birthdate;

    #[ORM\Column(enumType: Gender::class, length: 10)]
    private Gender $gender;

    #[ORM\Column(type: Types::STRING, length: 20)]
    private string $phone;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $address;

    #[ORM\Column(type: Types::STRING, length: 10)]
    private string $postalcode;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $city;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $password;

    #[ORM\Column(type: Types::JSON)]
    private array $roles;

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true)]
    private ?string $tutorLastname;

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true)]
    private ?string $tutorFirstname;

    #[ORM\Column(type: Types::STRING, length: 20, nullable: true)]
    private ?string $tutorPhone;

    #[ORM\Column(type: Types::STRING, length: 180, nullable: true)]
    private ?string $tutorEmail;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $tutorAddress;

    #[ORM\Column(type: Types::STRING, length: 10, nullable: true)]
    private ?string $tutorPostalcode;

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true)]
    private ?string $tutorCity;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $medicalCertificateExpiry;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $accessBadgeDeposit;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $annualMembershipFee;

    #[ORM\Column(type: Types::STRING, length: 10, unique: true, nullable: true)]
    private ?string $accessBadgeNumber;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    private ?string $passwordSetupToken = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $passwordSetupTokenExpiresAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $lastname,
        string $firstname,
        \DateTimeImmutable $birthdate,
        Gender $gender,
        string $phone,
        string $address,
        string $postalcode,
        string $city,
        string $email,
        ?\DateTimeImmutable $medicalCertificateExpiry,
        ?int $accessBadgeDeposit,
        ?int $annualMembershipFee,
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
    ) {
        $now = new \DateTimeImmutable('now');

        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->address = $address;
        $this->postalcode = $postalcode;
        $this->city = $city;
        $this->email = $email;
        $this->medicalCertificateExpiry = $medicalCertificateExpiry;
        $this->accessBadgeDeposit = $accessBadgeDeposit;
        $this->annualMembershipFee = $annualMembershipFee;
        $this->tutorLastname = $tutorLastname;
        $this->tutorFirstname = $tutorFirstname;
        $this->tutorPhone = $tutorPhone;
        $this->tutorEmail = $tutorEmail;
        $this->tutorAddress = $tutorAddress;
        $this->tutorPostalcode = $tutorPostalcode;
        $this->tutorCity = $tutorCity;
        $this->profileImage = $profileImage;

        // Initialisation des valeurs par défaut
        $this->id = Uuid::v4();
        $this->roles = [Role::Member->value];
        $this->createdAt = $now;
        $this->password = null;
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

    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getBirthdate(): \DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function getAge(): int
    {
        $today = new \DateTimeImmutable('today');

        return $this->birthdate->diff($today)->y;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPostalcode(): string
    {
        return $this->postalcode;
    }

    public function getCity(): string
    {
        return $this->city;
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

    public function getRole(): string
    {
        $role = $this->roles[0];

        return Role::tryFrom($role)->label();
    }

    public function getTutorLastname(): ?string
    {
        return $this->tutorLastname;
    }

    public function getTutorFirstname(): ?string
    {
        return $this->tutorFirstname;
    }

    public function getTutorPhone(): ?string
    {
        return $this->tutorPhone;
    }

    public function getTutorEmail(): ?string
    {
        return $this->tutorEmail;
    }

    public function getTutorAddress(): ?string
    {
        return $this->tutorAddress;
    }

    public function getTutorPostalcode(): ?string
    {
        return $this->tutorPostalcode;
    }

    public function getTutorCity(): ?string
    {
        return $this->tutorCity;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getMedicalCertificateExpiry(): ?\DateTimeImmutable
    {
        return $this->medicalCertificateExpiry;
    }

    public function getAccessBadgeDeposit(): ?int
    {
        return $this->accessBadgeDeposit;
    }

    public function getAnnualMembershipFee(): ?int
    {
        return $this->annualMembershipFee;
    }

    public function getAccessBadgeNumber(): ?string
    {
        return $this->accessBadgeNumber;
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

    public function setPassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function isValid(\DateTimeImmutable $now): bool
    {
        return $this->medicalCertificateExpiry !== null
            && $this->medicalCertificateExpiry > $now
            && $this->accessBadgeDeposit !== null
            && $this->annualMembershipFee !== null
            && $this->accessBadgeNumber !== null;
    }

    public function giveBadgeNumber(?string $number = null): void
    {
        $this->accessBadgeNumber = $number;
        $this->accessBadgeDeposit = 10;
    }

    public function renewMembership(): void
    {
        $this->annualMembershipFee = 50;
    }

    public function restitutionBadge(): void
    {
        $this->accessBadgeDeposit = null;
        $this->accessBadgeNumber = null;
    }

    public function assignRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function update(
        string $lastname,
        string $firstname,
        \DateTimeImmutable $birthdate,
        Gender $gender,
        string $phone,
        string $address,
        string $postalcode,
        string $city,
        string $email,
        ?\DateTimeImmutable $medicalCertificateExpiry = null,
        ?int $accessBadgeDeposit = null,
        ?int $annualMembershipFee = null,
        ?string $accessBadgeNumber = null,
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
    ): void
    {
        $this->lastname = \trim(\ucfirst(\strtolower($lastname)));
        $this->firstname = \trim(\ucfirst(\strtolower($firstname)));
        $this->birthdate = $birthdate;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->address = $address;
        $this->postalcode = $postalcode;
        $this->city = \trim(\ucfirst(\strtolower($city)));
        $this->email = \strtolower(\trim($email));
        $this->medicalCertificateExpiry = $medicalCertificateExpiry;
        $this->accessBadgeDeposit = $accessBadgeDeposit;
        $this->annualMembershipFee = $annualMembershipFee;
        $this->accessBadgeNumber = $accessBadgeNumber;
        $this->tutorLastname = null !== $tutorLastname ? \trim(\ucfirst(\strtolower($tutorLastname))) : null;
        $this->tutorFirstname = null !== $tutorFirstname ? \trim(\ucfirst(\strtolower($tutorFirstname))) : null;
        $this->tutorPhone = $tutorPhone;
        $this->tutorEmail = null !== $tutorEmail ? \strtolower(\trim($tutorEmail)) : null;
        $this->tutorAddress = $tutorAddress;
        $this->tutorPostalcode = $tutorPostalcode;
        $this->tutorCity = null !== $tutorCity ? \trim(\ucfirst(\strtolower($tutorCity))) : null;
        $this->profileImage = $profileImage;
    }

    public static function create(
        string $lastname,
        string $firstname,
        \DateTimeImmutable $birthdate,
        Gender $gender,
        string $phone,
        string $address,
        string $postalcode,
        string $city,
        string $email,
        ?\DateTimeImmutable $medicalCertificateExpiry,
        ?int $accessBadgeDeposit,
        ?int $annualMembershipFee,
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
    ): self
    {
        return new self(
            lastname: $lastname,
            firstname: $firstname,
            birthdate: $birthdate,
            gender: $gender,
            phone: $phone,
            address: $address,
            postalcode: $postalcode,
            city: $city,
            email: $email,
            medicalCertificateExpiry: $medicalCertificateExpiry,
            accessBadgeDeposit: $accessBadgeDeposit,
            annualMembershipFee: $annualMembershipFee,
            tutorLastname: $tutorLastname,
            tutorFirstname: $tutorFirstname,
            tutorPhone: $tutorPhone,
            tutorEmail: $tutorEmail,
            tutorAddress: $tutorAddress,
            tutorPostalcode: $tutorPostalcode,
            tutorCity: $tutorCity,
            profileImage: $profileImage,
        );
    }
}
