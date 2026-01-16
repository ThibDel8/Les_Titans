<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Domain\Handler;

use App\SharedKernel\Domain\Enum\Gender;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\SharedKernel\Membership\Domain\Entity\Membership;
use App\PublicApp\Membership\Domain\Service\Mailer\MembershipMailer;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;
use App\PublicApp\Membership\Domain\DTO\Request\MembershipCreationRequest;
use App\SharedKernel\Membership\Domain\Repository\MembershipWriteRepositoryInterface;

final class MembershipCreateHandler
{
    public function __construct(
        private MembershipMailer $membershipMailer,
        private ProfileImageService $profileImageService,
        private MembershipWriteRepositoryInterface $membershipWriteRepository,
    ) {
    }

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

        $this->membershipMailer->sendMembershipPdfDownload($membership);
        $this->membershipMailer->sendEmailNotificationToManager($membership);

        return $membership;
    }

    private function getCleanProfileImage(?UploadedFile $uploadedFile, Gender $gender): string
    {
        if (null === $uploadedFile) {
            $defaultFile = match ($gender->value) {
                Gender::Male->value => ProfileImageService::MALE_PROFILE,
                Gender::Female->value => ProfileImageService::FEMALE_PROFILE,
                Gender::Other->value => ProfileImageService::OTHER_PROFILE,
            };
            $originalPath = $this->profileImageService->getDefaultsDir() . $defaultFile;
        } else {
            $originalPath = $uploadedFile->getPathname();
        }

        return $this->profileImageService->save($originalPath);
    }
}
