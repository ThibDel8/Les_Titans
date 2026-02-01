<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Infrastructure\Doctrine\Repository;

use App\MemberApp\Membership\Domain\Repository\MembershipWriteRepositoryInterface;
use App\MemberApp\Post\Domain\Repository\PostWriteRepositoryInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostWriteRepository extends AbstractWriteRepository implements PostWriteRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
