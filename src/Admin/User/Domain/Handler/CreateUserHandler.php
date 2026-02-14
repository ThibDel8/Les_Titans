<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use App\Admin\User\Domain\Service\Mailer\UserMailer;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\MemberApp\Membership\Domain\Repository\MembershipWriteRepositoryInterface;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserMailer $userMailer,
        private UserReadRepositoryInterface $userReadRepository,
        private UserWriteRepositoryInterface $userWriteRepository,
        private MembershipWriteRepositoryInterface $membershipWriteRepository,
    ) {
    }

    public function handle(Membership $membership): ?User
    {
        $existingUser = $this->userReadRepository->findByEmail($membership->getEmail());

        if (null !== $existingUser) {
            return null;
        }

        $user = $this->createNewUser($membership);

        $this->userWriteRepository->save($user);

        $this->userMailer->sendPasswordSetupEmail($user);

        $this->deleteMembership($membership);

        return $user;
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
        $this->membershipWriteRepository->delete($membership);
    }
}
