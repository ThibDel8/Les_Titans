<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Entity\Security\User;
use App\Entity\Membership\Membership;
use App\Service\User\Mailer\UserMailer;
use App\Repository\Security\UserRepository;
use App\Repository\Membership\MembershipRepository;

final class CreateUserHandler
{
    public function __construct(
        private UserMailer $userMailer,
        private UserRepository $userRepository,
        private MembershipRepository $membershipRepository,
    )
    {
    }

    public function handle(Membership $membership): bool
    {
        $existingUser = $this->userRepository->findOneBy(['email' => $membership->getEmail()]);

        if (null === $existingUser) {
            $user = $this->createNewUser($membership);

            $this->userRepository->save($user);

            $this->userMailer->sendPasswordSetupEmail($user);

            $this->deleteMembership($membership);
        }

        return null === $existingUser;
    }

    private function createNewUser(Membership $membership): User
    {
        return User::create(
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
