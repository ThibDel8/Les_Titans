<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Domain\QueryHandler;

use App\MemberApp\Membership\Domain\Entity\Membership;
use App\PublicApp\Membership\Domain\DTO\Pdf\MembershipPdf;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class MembershipPdfQuery
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function fetch(Membership $membership): MembershipPdf
    {
        return MembershipPdf::create(
            lastname: $membership->getLastname(),
            firstname: $membership->getFirstname(),
            birthday: $membership->getBirthdate()->format('d/m/Y'),
            age: $membership->getAge(),
            gender: ucfirst($this->translator->trans($membership->getGender()->label())),
            phone: $membership->getPhone(),
            address: $membership->getAddress().', '.$membership->getPostalcode().' '.$membership->getCity(),
            tutorNames: $membership->getTutorFirstname().' '.$membership->getTutorLastname(),
            tutorAddress: $membership->getTutorAddress(),
        );
    }
}
