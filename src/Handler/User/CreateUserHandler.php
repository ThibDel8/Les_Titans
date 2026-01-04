<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Entity\Member\Member;
use App\Entity\Security\User;
use App\Enum\Security\Role;
use App\Repository\Security\UserRepository;
use App\Service\User\Mailer\UserMailer;

final class CreateUserHandler
{
    public function __construct(
        private UserMailer $userMailer,
        private UserRepository $userRepository,
    )
    {
    }

    public function handle(Member $member): bool
    {
        $existingUser = $this->userRepository->findOneBy(['email' => $member->getEmail()]);

        if (null === $existingUser) {
            $user = $this->createNewUser($member);

            $this->userRepository->save($user);

            $this->userMailer->sendPasswordSetupEmail($user);
        }

        return null === $existingUser;
    }

    private function createNewUser(Member $member): User
    {
        return User::create(
            member: $member,
            roles: [Role::Manager],
            email: $member->getEmail(),
        );
    }
}
