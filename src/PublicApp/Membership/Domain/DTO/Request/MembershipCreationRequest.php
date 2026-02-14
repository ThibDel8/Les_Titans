<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Domain\DTO\Request;

use App\SharedKernel\Domain\Enum\Gender;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class MembershipCreationRequest
{
    #[Assert\File(
        mimeTypes: [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/bmp',
            'image/x-ms-bmp',
            'image/webp',
            'image/vnd.wap.wbmp',
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

    #[Callback]
    public function validateTutorFields(ExecutionContextInterface $context): void
    {
        $today = new \DateTimeImmutable('today');
        $age = $this->birthdate->diff($today)->y;

        if ($age < 18) {
            $requiredFields = [
                'tutorLastname' => $this->tutorLastname,
                'tutorFirstname' => $this->tutorFirstname,
                'tutorPhone' => $this->tutorPhone,
                'tutorEmail' => $this->tutorEmail,
                'tutorAddress' => $this->tutorAddress,
                'tutorPostalcode' => $this->tutorPostalcode,
                'tutorCity' => $this->tutorCity,
            ];

            foreach ($requiredFields as $fieldName => $value) {
                if (empty($value)) {
                    $context->buildViolation('Ce champ est obligatoire pour un mineur.')
                        ->atPath($fieldName)
                        ->addViolation();
                }
            }
        }
    }
}
