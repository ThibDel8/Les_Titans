<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Admin\User\Domain\Entity\User;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $secretaryUser = $this->getReference('secretary_user', User::class);

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
        );

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
            assignTo: $secretaryUser,
            answer: $faker->sentence(),
        );

        $this->createContactMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            body: $faker->sentence(),
            assignTo: $secretaryUser,
        );

        $this->createContactMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            body: $faker->sentence(),
            assignTo: $secretaryUser,
            answer: $faker->sentence(),
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
        ?User $assignTo = null,
        ?string $answer = null,
    ): void
    {
        $message = ContactMessage::create(
            email: $email,
            subject: $subject,
            body: $body,
        );

        if (null !== $assignTo) {
            $message->saveAssignTo($assignTo);
        }

        if (null !== $answer) {
            $message->saveAnswer(answer: $answer, boardMember: $assignTo);
        }

        $manager->persist($message);
    }
}
