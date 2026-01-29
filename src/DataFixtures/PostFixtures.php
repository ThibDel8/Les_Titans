<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Post\Domain\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $secretaryPost = $this->createPost(
            manager: $manager,
            author: $this->getReference('secretary_user', User::class),
            text: $faker->realText(),
        );

        $this->addReference('secretary_post', $secretaryPost);

        $ghostUserPost = $this->createPost(
            manager: $manager,
            author: null,
            text: $faker->realText(),
        );

        $this->addReference('ghost_user_post', $ghostUserPost);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    private function createPost(
        ObjectManager $manager,
        ?User $author,
        string $text,
        array $attachments = [],
        array $linkPreview = [],
    ): Post
    {
        $post = Post::create(
            author: $author,
            text: $text,
            attachments: $attachments,
            linkPreview: $linkPreview,
        );

        $manager->persist($post);

        return $post;
    }
}
