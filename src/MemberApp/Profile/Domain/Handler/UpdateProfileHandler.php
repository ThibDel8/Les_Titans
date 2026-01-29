<?php

declare(strict_types=1);

namespace App\MemberApp\Profile\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use App\MemberApp\Profile\Domain\DTO\Request\ProfileRequest;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateProfileHandler
{
    public function __construct(
        private UserWriteRepositoryInterface $userWriteRepository,
        private ProfileImageService $profileImageService,
    ) {
    }

    public function handle(User $user, ProfileRequest $request): void
    {
        $uploadedProfileImage = $request->profileImage;
        $profileImage = $user->getProfileImage();

        if ($uploadedProfileImage) {
            $profileImage = $this->getCleanProfileImage(newImage: $uploadedProfileImage, oldImagePath: $profileImage);
        }

        $user->update(
            lastname: $request->lastname,
            firstname: $request->firstname,
            birthdate: $request->birthdate,
            gender: $request->gender,
            phone: $request->phone,
            address: $request->address,
            postalcode: $request->postalcode,
            city: $request->city,
            email: $request->email,
            medicalCertificateExpiry: $user->getMedicalCertificateExpiry(),
            accessBadgeDeposit: $user->getAccessBadgeDeposit(),
            annualMembershipFee: $user->getAnnualMembershipFee(),
            accessBadgeNumber: $user->getAccessBadgeNumber(),
            tutorLastname: $request->tutorLastname,
            tutorFirstname: $request->tutorFirstname,
            tutorPhone: $request->tutorPhone,
            tutorEmail: $request->tutorEmail,
            tutorAddress: $request->tutorAddress,
            tutorPostalcode: $request->tutorPostalcode,
            tutorCity: $request->tutorCity,
            profileImage: $profileImage,
        );

        $this->userWriteRepository->save($user);
    }

    private function getCleanProfileImage(UploadedFile $newImage, string $oldImagePath): string
    {
        $newImagePath = $newImage->getPathname();

        return $this->profileImageService->update($newImagePath, $oldImagePath);
    }
}
