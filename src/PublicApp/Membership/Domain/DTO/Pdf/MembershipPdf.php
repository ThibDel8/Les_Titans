<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Domain\DTO\Pdf;

class MembershipPdf
{
    public function __construct(
        public string $lastname,
        public string $firstname,
        public string $birthday,
        public int $age,
        public string $gender,
        public string $phone,
        public string $address,
        public int $annualFee,
        public int $accessBadgeDeposit,
        public \DateTimeImmutable $now = new \DateTimeImmutable('now'),
        public int $majorityAge = 18,
        public ?string $tutorNames = null,
        public ?string $tutorAddress = null,
    ) {
    }

    public static function create(
        string $lastname,
        string $firstname,
        string $birthday,
        int $age,
        string $gender,
        string $phone,
        string $address,
        ?string $tutorNames,
        ?string $tutorAddress,
        int $annualFee,
        int $accessBadgeDeposit,
    ): self {
        return new self(
            lastname: $lastname,
            firstname: $firstname,
            birthday: $birthday,
            age: $age,
            gender: $gender,
            phone: $phone,
            address: $address,
            annualFee: $annualFee,
            accessBadgeDeposit: $accessBadgeDeposit,
            tutorNames: $tutorNames,
            tutorAddress: $tutorAddress,
        );
    }
}
