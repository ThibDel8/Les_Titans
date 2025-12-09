<?php

declare(strict_types=1);

namespace App\Handler\Member;

use App\Entity\Member\Member;
use App\Entity\Membership\Membership;
use App\Repository\Member\MemberRepository;
use App\Repository\Membership\MembershipRepository;

final class CreateMemberHandler
{
    public function __construct(
        private MemberRepository $memberRepository,
        private MembershipRepository $membershipRepository,
    )
    {
    }

    public function handle(Membership $membership): void
    {
        $member = $this->createNewMember($membership);

        $this->memberRepository->save($member);

        $this->deleteMembership($membership);
    }

    private function createNewMember(Membership $membership): Member
    {
        return Member::create(
            lastname: $membership->getLastname(),
            firstname: $membership->getFirstname(),
            birthdate: $membership->getBirthdate(),
            gender: $membership->getGender(),
            phone: $membership->getPhone(),
            address: $membership->getAddress(),
            postalcode: $membership->getPostalcode(),
            city: $membership->getCity(),
            email: $membership->getEmail(),
            medicalCertificateExpiry: $membership->getMedicalCertificateExpiry(),
            accessBadgeDeposit: $membership->getAccessBadgeDeposit(),
            annualMembershipFee: $membership->getAnnualMembershipFee(),
            tutorLastname: $membership->getTutorLastname(),
            tutorFirstname: $membership->getTutorFirstname(),
            tutorPhone: $membership->getTutorPhone(),
            tutorEmail: $membership->getTutorEmail(),
            tutorAddress: $membership->getTutorAddress(),
            tutorPostalcode: $membership->getTutorPostalcode(),
            tutorCity: $membership->getTutorCity(),
            profileImage: $membership->getProfileImage(),
        );
    }

    private function deleteMembership($membership): void
    {
        $this->membershipRepository->delete($membership);
    }
}
