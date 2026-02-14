<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Infrastructure\Doctrine\Repository;

use App\MemberApp\Post\Domain\Repository\CommentReadRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class CommentReadRepository extends ServiceEntityRepository implements CommentReadRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
