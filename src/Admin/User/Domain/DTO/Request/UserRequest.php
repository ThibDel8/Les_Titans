<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\DTO\Request;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use App\SharedKernel\Domain\Enum\Gender;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserRequest
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

    #[Assert\Choice(callback: [Role::class, 'values'])]
    public string $roles;

    public static function fromEntity(User $user): self
    {
        $dto = new self();
        $dto->lastname = $user->getLastname();
        $dto->firstname = $user->getFirstname();
        $dto->birthdate = $user->getBirthdate();
        $dto->gender = $user->getGender();
        $dto->phone = $user->getPhone();
        $dto->address = $user->getAddress();
        $dto->postalcode = $user->getPostalcode();
        $dto->city = $user->getCity();
        $dto->email = $user->getEmail();
        $dto->medicalCertificateExpiry = $user->getMedicalCertificateExpiry();
        $dto->accessBadgeDeposit = $user->getAccessBadgeDeposit();
        $dto->annualMembershipFee = $user->getAnnualMembershipFee();
        $dto->accessBadgeNumber = $user->getAccessBadgeNumber();
        $dto->tutorLastname = $user->getTutorLastname();
        $dto->tutorFirstname = $user->getTutorFirstname();
        $dto->tutorPhone = $user->getTutorPhone();
        $dto->tutorEmail = $user->getTutorEmail();
        $dto->tutorAddress = $user->getTutorAddress();
        $dto->tutorPostalcode = $user->getTutorPostalcode();
        $dto->tutorCity = $user->getTutorCity();
        $dto->roles = array_first($user->getRoles());

        return $dto;
    }
}
