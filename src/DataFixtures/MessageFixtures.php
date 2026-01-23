<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Faker\Factory;
use Symfony\Component\Uid\Uuid;
use App\Admin\User\Domain\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Contact\Domain\Entity\ContactMessage;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $secretaryUserId = $this->getReference('secretary_user', User::class)->getUuid();

        $this->createContactMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            body: $faker->sentence(),
        );

        $this->createContactMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            body: $faker->sentence(),
            assignTo: $secretaryUserId,
            answer: $faker->sentence(),
        );

        $this->createContactMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            body: $faker->sentence(),
            assignTo: $secretaryUserId,
        );

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    private function createContactMessage(
        ObjectManager $manager,
        string $email,
        string $subject,
        string $body,
        ?Uuid $assignTo = null,
        ?string $answer = null,
    ): void
    {
        $message = ContactMessage::create(
            email: $email,
            subject: $subject,
            body: $body,
        );

        if (null !== $assignTo) {
            $message->assignTo($assignTo);
        }

        if (null !== $answer) {
            $message->answer(answer: $answer, adminId: $assignTo);
            $message->archive();
        }

        $manager->persist($message);
    }
}
