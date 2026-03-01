<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Admin\AuditLog\Domain\Entity\AuditLog;
use App\Admin\AuditLog\Domain\Enum\Action;
use App\Admin\AuditLog\Domain\Enum\EntityType;
use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Membership\Domain\Entity\Membership;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AuditLogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $secretaryUser = $this->getReference('secretary_user', User::class);
        $newUser = $this->getReference('new_user', User::class);
        $membership = $this->getReference('membership', Membership::class);

        $this->createAuditLog(
            manager: $manager,
            authorId: $secretaryUser->getId(),
            authorFullname: $secretaryUser->getFullname(),
            authorEmail: $secretaryUser->getEmail(),
            action: Action::Create,
            entityType: EntityType::User,
            entityId: $newUser->getId(),
        );

        $this->createAuditLog(
            manager: $manager,
            authorId: $secretaryUser->getId(),
            authorFullname: $secretaryUser->getFullname(),
            authorEmail: $secretaryUser->getEmail(),
            action: Action::Delete,
            entityType: EntityType::Membership,
            entityId: $membership->getId(),
            message: 'Suppression automatique suite à sa validation.',
        );

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            MembershipFixtures::class,
        ];
    }

    private function createAuditLog(
        ObjectManager $manager,
        string $authorId,
        string $authorFullname,
        string $authorEmail,
        Action $action,
        EntityType $entityType,
        string $entityId,
        ?string $message = null,
    ): void {
        $membership = AuditLog::create(
            authorId: $authorId,
            authorFullname: $authorFullname,
            authorEmail: $authorEmail,
            action: $action,
            entityType: $entityType,
            entityId: $entityId,
            message: $message,
        );

        $manager->persist($membership);
    }
}
