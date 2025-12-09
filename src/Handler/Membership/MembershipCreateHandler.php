<?php

declare(strict_types=1);

namespace App\Handler\Membership;

use App\Entity\Membership\Membership;
use App\DTO\Request\Membership\MembershipCreationRequest;
use App\Repository\Membership\MembershipRepository;
use App\Service\ProfileImage\ProfileImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MembershipCreateHandler
{
    public function __construct(
        private MembershipRepository $repository,
        private ProfileImageService $profileImageService,
    ) {
    }

    public function handle(MembershipCreationRequest $request): Membership
    {
        $uploadedProfileImage = $request->profileImage;
        $profileImage = null;

        if ($uploadedProfileImage) {
            $profileImage = $this->getCleanProfileImage($uploadedProfileImage);
        }

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

        $this->repository->save($membership);

        return $membership;
    }

    private function getCleanProfileImage(UploadedFile $uploadedFile): string
    {
        $originalPath = $uploadedFile->getPathname();

        return $this->profileImageService->save($originalPath);
    }
}
