<?php

declare(strict_types=1);

namespace App\Entity\Member;

use App\Entity\Security\User;
use Doctrine\DBAL\Types\Types;
use App\Enum\Membership\Gender;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Member\MemberRepository;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\Table(name: 'members')]
class Member
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

    #[ORM\Column(type: Types::STRING, length: 10, unique: true, nullable: true)]
    private ?string $accessBadgeNumber;

    #[ORM\OneToOne(targetEntity: User::class, mappedBy: 'member', cascade: ['remove'])]
    private ?User $user = null;

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
        \DateTimeImmutable $medicalCertificateExpiry,
        int $accessBadgeDeposit,
        int $annualMembershipFee,
        ?string $tutorLastname = null,
        ?string $tutorFirstname = null,
        ?string $tutorPhone = null,
        ?string $tutorEmail = null,
        ?string $tutorAddress = null,
        ?string $tutorPostalcode = null,
        ?string $tutorCity = null,
        ?string $profileImage = null,
    )
    {
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
        $this->createdAt = $now;
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

    public function getUser(): ?User
    {
        return $this->user;
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
        $this->accessBadgeNumber = $accessBadgeNumber;
        $this->tutorLastname = $tutorLastname;
        $this->tutorFirstname = $tutorFirstname;
        $this->tutorPhone = $tutorPhone;
        $this->tutorEmail = $tutorEmail;
        $this->tutorAddress = $tutorAddress;
        $this->tutorPostalcode = $tutorPostalcode;
        $this->tutorCity = $tutorCity;
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
        \DateTimeImmutable $medicalCertificateExpiry,
        int $accessBadgeDeposit,
        int $annualMembershipFee,
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
