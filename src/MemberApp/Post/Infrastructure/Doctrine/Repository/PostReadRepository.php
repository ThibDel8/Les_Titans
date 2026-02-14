<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Infrastructure\Doctrine\Repository;

use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Repository\PostReadRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostReadRepository extends ServiceEntityRepository implements PostReadRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }

    public function findAllPosts(): array
    {
        return $this->manager->getRepository(Post::class)->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
