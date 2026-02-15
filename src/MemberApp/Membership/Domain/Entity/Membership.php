<?php

declare(strict_types=1);

namespace App\MemberApp\Membership\Domain\Entity;

use App\SharedKernel\Domain\Enum\Gender;
use App\SharedKernel\Domain\Service\Utils\Formatter\StringFormatter;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'memberships')]
class Membership
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', length: 36)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $profileImage;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $lastname;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $firstname;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $birthdate;

    #[ORM\Column(length: 10, enumType: Gender::class)]
    private Gender $gender;

    #[ORM\Column(type: Types::STRING, length: 20)]
    private string $phone;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $address;

    #[ORM\Column(type: Types::STRING, length: 10)]
    private string $postalcode;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $city;

    #[ORM\Column(type: Types::STRING, length: 180)]
    private string $email;

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

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeInterface $createdAt;

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
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
    ) {
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->address = $address;
        $this->postalcode = $postalcode;
        $this->city = $city;
        $this->email = $email;
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
        $this->createdAt = new \DateTimeImmutable('now');
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

    public function hasValidRegistration(): bool
    {
        return null !== $this->medicalCertificateExpiry
            && null !== $this->accessBadgeDeposit
            && null !== $this->annualMembershipFee;
    }

    public function updateValidation(
        ?int $annualMembershipFee = null,
        ?int $accessBadgeDeposit = null,
        ?\DateTimeImmutable $medicalCertificateExpiry = null,
    ): void {
        $this->medicalCertificateExpiry = $medicalCertificateExpiry;
        $this->accessBadgeDeposit = $accessBadgeDeposit;
        $this->annualMembershipFee = $annualMembershipFee;
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
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
    ): self {
        return new self(
            lastname: StringFormatter::properNoun($lastname),
            firstname: StringFormatter::properNoun($firstname),
            birthdate: $birthdate,
            gender: $gender,
            phone: $phone,
            address: StringFormatter::address($address),
            postalcode: $postalcode,
            city: StringFormatter::address($city),
            email: \strtolower(\trim($email)),
            tutorLastname: null !== $tutorLastname ? StringFormatter::properNoun($tutorLastname) : null,
            tutorFirstname: null !== $tutorFirstname ? StringFormatter::properNoun($tutorFirstname) : null,
            tutorPhone: $tutorPhone,
            tutorEmail: null !== $tutorEmail ? \strtolower(\trim($tutorEmail)) : null,
            tutorAddress: null !== $tutorAddress ? StringFormatter::address($tutorAddress) : null,
            tutorPostalcode: $tutorPostalcode,
            tutorCity: null !== $tutorCity ? StringFormatter::address($tutorCity) : null,
            profileImage: $profileImage,
        );
    }
}
