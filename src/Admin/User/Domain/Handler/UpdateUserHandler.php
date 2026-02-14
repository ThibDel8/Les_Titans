<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\DTO\Request\UserRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use App\SharedKernel\Domain\Service\ProfileImage\ProfileImageService;

final class UpdateUserHandler
{
    public function __construct(
        private UserWriteRepositoryInterface $userWriteRepository,
        private ProfileImageService $profileImageService,
    ) {
    }

    public function handle(User $user, UserRequest $request): void
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
            medicalCertificateExpiry: $request->medicalCertificateExpiry,
            accessBadgeDeposit: $request->accessBadgeDeposit,
            annualMembershipFee: $request->annualMembershipFee,
            accessBadgeNumber: $request->accessBadgeNumber,
            tutorLastname: $request->tutorLastname,
            tutorFirstname: $request->tutorFirstname,
            tutorPhone: $request->tutorPhone,
            tutorEmail: $request->tutorEmail,
            tutorAddress: $request->tutorAddress,
            tutorPostalcode: $request->tutorPostalcode,
            tutorCity: $request->tutorCity,
            profileImage: $profileImage,
        );

        $user->assignRoles([$request->roles]);

        $this->userWriteRepository->save($user);
    }

    private function getCleanProfileImage(UploadedFile $newImage, string $oldImagePath): string
    {
        $newImagePath = $newImage->getPathname();

        return $this->profileImageService->update($newImagePath, $oldImagePath);
    }
}
