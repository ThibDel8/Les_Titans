<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Post\Domain\Entity\Comment;
use App\MemberApp\Post\Domain\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const string ID_SECRETARY_COMMENT = '019ca9d0-ba5c-79a1-bf2e-fef80f8f4c2f';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $secretaryUser = $this->getReference('secretary_user', User::class);
        $secretaryPost = $this->getReference('secretary_post', Post::class);
        $ghostUserPost = $this->getReference('ghost_user_post', Post::class);

        $this->createComment(
            manager: $manager,
            post: $ghostUserPost,
            author: $secretaryUser,
            text: $faker->realText(),
            id: self::ID_SECRETARY_COMMENT,
        );

        $this->createComment(
            manager: $manager,
            post: $ghostUserPost,
            author: null,
            text: $faker->realText(),
        );

        $this->createComment(
            manager: $manager,
            post: $secretaryPost,
            author: null,
            text: $faker->realText(),
        );

        $this->createComment(
            manager: $manager,
            post: $secretaryPost,
            author: $secretaryUser,
            text: $faker->realText(),
        );

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixtures::class,
        ];
    }

    private function createComment(
        ObjectManager $manager,
        Post $post,
        ?User $author,
        string $text,
        ?string $id = null,
    ): void {
        $membership = Comment::create(
            post: $post,
            author: $author,
            text: $text,
            id: $id,
        );

        $manager->persist($membership);
    }
}
