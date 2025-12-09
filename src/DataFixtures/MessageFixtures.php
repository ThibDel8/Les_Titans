<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Security\User;
use App\Entity\Contact\Message;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $managerUser = $this->getReference('manager_user', User::class);

        $this->createMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            message: $faker->sentence(),
        );

        $this->createMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            message: $faker->sentence(),
            isUnread: false,
        );

        $this->createMessage(
            manager: $manager,
            email: $faker->email(),
            subject: $faker->sentence(),
            message: $faker->sentence(),
            isUnread: false,
            answerBy: $managerUser->getMember()->getFirstname() . ' ' . $managerUser->getMember()->getLastname(),
        );

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    private function createMessage(
        ObjectManager $manager,
        string $email,
        string $subject,
        string $message,
        bool $isUnread = true,
        ?string $answerBy = null,
    ): void
    {
        $message = Message::create(
            email: $email,
            subject: $subject,
            message: $message,
        );

        if (false === $isUnread) {
            $message->markAsRead();
        }

        if ($answerBy !== null) {
            $message->markAsAnswerBy($answerBy);
        }

        $manager->persist($message);
    }
}
