<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Domain\Handler;

use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\MemberApp\Membership\Domain\Entity\Membership;
use App\MemberApp\Membership\Domain\Repository\MembershipWriteRepositoryInterface;
use App\PublicApp\Membership\Domain\DTO\Request\MembershipCreationRequest;
use App\PublicApp\Membership\Domain\Service\Mailer\MembershipMailer;
use App\SharedKernel\Domain\Enum\Gender;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;
use Random\RandomException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

final readonly class MembershipCreateHandler
{
    public function __construct(
        private MembershipMailer $membershipMailer,
        private ProfileImageService $profileImageService,
        private UserReadRepositoryInterface $userReadRepository,
        private MembershipWriteRepositoryInterface $membershipWriteRepository,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws RandomException
     */
    public function handle(MembershipCreationRequest $request): Membership
    {
        $uploadedProfileImage = $request->profileImage;

        $profileImage = $this->getCleanProfileImage($uploadedProfileImage, $request->gender);

        $membership = Membership::create(
            lastname: $request->lastname,
            firstname: $request->firstname,
            birthdate: $request->birthdate,
            gender: $request->gender,
            phone: $request->phone,
            address: $request->address,
            postalcode: $request->postalcode,
            city: $request->city,
            email: $request->email,
            tutorLastname: $request->tutorLastname,
            tutorFirstname: $request->tutorFirstname,
            tutorPhone: $request->tutorPhone,
            tutorEmail: $request->tutorEmail,
            tutorAddress: $request->tutorAddress,
            tutorPostalcode: $request->tutorPostalcode,
            tutorCity: $request->tutorCity,
            profileImage: $profileImage,
        );

        $this->membershipWriteRepository->save($membership);

        $boardMemberEmails = $this->getBoardMemberEmails();

        $this->membershipMailer->sendMembershipPdfDownload($membership);
        $this->membershipMailer->sendEmailNotificationToBoardMembers($membership, $boardMemberEmails);

        return $membership;
    }

    /**
     * @throws RandomException
     */
    private function getCleanProfileImage(?UploadedFile $uploadedFile, Gender $gender): string
    {
        if (null === $uploadedFile) {
            $defaultFile = match ($gender->value) {
                Gender::Male->value => ProfileImageService::MALE_PROFILE,
                Gender::Female->value => ProfileImageService::FEMALE_PROFILE,
                Gender::Other->value => ProfileImageService::OTHER_PROFILE,
            };
            $originalPath = $this->profileImageService->getDefaultsDir().$defaultFile;
        } else {
            $originalPath = $uploadedFile->getPathname();
        }

        return $this->profileImageService->save($originalPath);
    }

    private function getBoardMemberEmails(): array
    {
        $boardMembers = $this->userReadRepository->getBoardMembers();

        $boardMemberEmails = [];
        foreach ($boardMembers as $member) {
            $boardMemberEmails[] = $member->getEmail();
        }

        return Address::createArray($boardMemberEmails);
    }
}
