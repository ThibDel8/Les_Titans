<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Enum\Security\Role;
use App\Entity\Member\Member;
use App\Entity\Security\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $member = $this->getReference('member_user', Member::class);

        $managerUser = $this->createUser(
            manager: $manager,
            member: $member,
            roles: [Role::Manager->value],
            email: $member->getEmail(),
        );

        $this->addReference('manager_user', $managerUser);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MemberFixtures::class,
        ];
    }

    private function createUser(
        ObjectManager $manager,
        Member $member,
        array $roles,
        string $email,
    ): User
    {
        $user = User::create(
            member: $member,
            roles: $roles,
            email: $email,
        );

        $manager->persist($user);

        return $user;
    }
}
