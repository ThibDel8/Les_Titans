<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Entity\Security\User;
use App\DTO\Request\User\UserRequest;
use App\Repository\Security\UserRepository;
use App\Service\ProfileImage\ProfileImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpdateUserHandler
{
    public function __construct(
        private UserRepository $repository,
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

        $this->repository->save($user);
    }

    private function getCleanProfileImage(UploadedFile $newImage, string $oldImagePath): string
    {
        $newImagePath = $newImage->getPathname();

        return $this->profileImageService->update($newImagePath, $oldImagePath);
    }
}
