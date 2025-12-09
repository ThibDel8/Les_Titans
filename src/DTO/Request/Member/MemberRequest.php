<?php

declare(strict_types=1);

namespace App\DTO\Request\Member;

use App\Entity\Member\Member;
use App\Enum\Membership\Gender;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MemberRequest
{
    #[Assert\File(
        mimeTypes: [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/bmp',
            'image/x-ms-bmp',
            'image/webp',
            'image/vnd.wap.wbmp'
        ],
        mimeTypesMessage: 'L\'image doit être au format JPEG, PNG, GIF, BMP, WebP ou WBMP.'
    )]
    public ?UploadedFile $profileImage = null;

    #[Assert\NotBlank(message: 'Le nom doit être renseigné.')]
    public ?string $lastname = null;

    #[Assert\NotBlank(message: 'Le prénom doit être renseigné.')]
    public ?string $firstname = null;

    #[Assert\NotBlank(message: 'La date de naissance doit être renseignée.')]
    #[Assert\LessThan(
        value: 'today',
        message: 'La date de naissance ne peut pas être après aujourd\'hui.'
    )]
    public ?\DateTimeImmutable $birthdate = null;

    #[Assert\NotBlank(message: 'Le sexe doit être renseigné.')]
    public ?Gender $gender = null;

    #[Assert\NotBlank(message: 'Le numéro de téléphone doit être renseigné.')]
    #[Assert\Length(
        exactly: 10,
        exactMessage: 'Le numéro de téléphone doit contenir 10 chiffres.'
    )]
    #[Assert\Regex(
        pattern: '/^0[1-9][0-9]{8}$/',
        message: 'Le numéro de téléphone doit commencer par 0.'
    )]
    public ?string $phone = null;

    #[Assert\NotBlank(message: 'L\'adresse postale doit être renseignée.')]
    public ?string $address = null;

    #[Assert\NotBlank(message: 'Le code postal doit être renseigné.')]
    #[Assert\Length(
        exactly: 5,
        exactMessage: 'Le code postal doit contenir 5 chiffres.'
    )]
    #[Assert\Regex(
        pattern:'/^\d{5}$/',
        message: 'Le code postal doit contenir uniquement des chiffres.'
    )]
    public ?string $postalcode = null;

    #[Assert\NotBlank(message: 'La ville doit être renseignée.')]
    public ?string $city = null;

    #[Assert\NotBlank(message: 'L\'email doit être renseigné.')]
    #[Assert\Email(message: 'Ceci n\'est pas un email valide.')]
    public ?string $email = null;

    #[Assert\Type(\DateTimeImmutable::class)]
    #[Assert\GreaterThan("today", message: "Le certificat médical doit être plus ancien qu'aujourd'hui.")]
    public ?\DateTimeImmutable $medicalCertificateExpiry = null;

    #[Assert\Type("integer")]
    #[Assert\PositiveOrZero(message: "Le dépôt du badge doit être positif ou nul.")]
    public ?int $accessBadgeDeposit = null;

    #[Assert\Type("string")]
    #[Assert\Regex(
        pattern: '/^\d{10}$/',
        message: 'Le numéro de badge doit contenir exactement 10 chiffres.'
    )]
    public ?string $accessBadgeNumber = null;


    #[Assert\Type("integer")]
    #[Assert\PositiveOrZero(message: "La cotisation annuelle doit être positive ou nulle.")]
    public ?int $annualMembershipFee = null;

    public ?string $tutorLastname = null;

    public ?string $tutorFirstname = null;

    #[Assert\Length(
        exactly: 10,
        exactMessage: 'Le numéro de téléphone doit contenir 10 chiffres.'
    )]
    #[Assert\Regex(
        pattern: '/^0[1-9][0-9]{8}$/',
        message: 'Le numéro de téléphone doit commencer par 0.'
    )]
    public ?string $tutorPhone = null;

    #[Assert\Email(message: 'Ceci n\'est pas un email valide.')]
    public ?string $tutorEmail = null;

    public ?string $tutorAddress = null;

    #[Assert\Length(
        exactly: 5,
        exactMessage: 'Le code postal doit contenir 5 chiffres.'
    )]
    #[Assert\Regex(
        pattern:'/^\d{5}$/',
        message: 'Le code postal doit contenir uniquement des chiffres.'
    )]
    public ?string $tutorPostalcode = null;

    public ?string $tutorCity = null;

    public static function fromEntity(Member $member): self
    {
        $dto = new self();
        $dto->lastname = $member->getLastname();
        $dto->firstname = $member->getFirstname();
        $dto->birthdate = $member->getBirthdate();
        $dto->gender = $member->getGender();
        $dto->phone = $member->getPhone();
        $dto->address = $member->getAddress();
        $dto->postalcode = $member->getPostalcode();
        $dto->city = $member->getCity();
        $dto->email = $member->getEmail();
        $dto->medicalCertificateExpiry = $member->getMedicalCertificateExpiry();
        $dto->accessBadgeDeposit = $member->getAccessBadgeDeposit();
        $dto->annualMembershipFee = $member->getAnnualMembershipFee();
        $dto->accessBadgeNumber = $member->getAccessBadgeNumber();
        $dto->tutorLastname = $member->getTutorLastname();
        $dto->tutorFirstname = $member->getTutorFirstname();
        $dto->tutorPhone = $member->getTutorPhone();
        $dto->tutorEmail = $member->getTutorEmail();
        $dto->tutorAddress = $member->getTutorAddress();
        $dto->tutorPostalcode = $member->getTutorPostalcode();
        $dto->tutorCity = $member->getTutorCity();

        return $dto;
    }
}
