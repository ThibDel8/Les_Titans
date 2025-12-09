<?php

declare(strict_types=1);

namespace App\Handler\Member;

use App\Entity\Member\Member;
use App\DTO\Request\Member\MemberRequest;
use App\Repository\Member\MemberRepository;
use App\Service\ProfileImage\ProfileImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpdateMemberHandler
{
    public function __construct(
        private MemberRepository $repository,
        private ProfileImageService $profileImageService,
    ) {
    }

    public function handle(Member $member, MemberRequest $request): void
    {
        $uploadedProfileImage = $request->profileImage;
        $profileImage = $member->getProfileImage();

        if ($uploadedProfileImage) {
            $profileImage = $this->getCleanProfileImage(newImage: $uploadedProfileImage, oldImagePath: $profileImage);
        }

        $member->update(
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

        $this->repository->save($member);
    }

    private function getCleanProfileImage(UploadedFile $newImage, string $oldImagePath): string
    {
        $newImagePath = $newImage->getPathname();

        return $this->profileImageService->update($newImagePath, $oldImagePath);
    }
}
