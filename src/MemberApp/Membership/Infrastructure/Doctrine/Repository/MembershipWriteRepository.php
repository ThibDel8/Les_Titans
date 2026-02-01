<?php

declare(strict_types=1);

namespace App\MemberApp\Membership\Infrastructure\Doctrine\Repository;

use App\MemberApp\Membership\Domain\Repository\MembershipWriteRepositoryInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;
use Doctrine\ORM\EntityManagerInterface;

class MembershipWriteRepository extends AbstractWriteRepository implements MembershipWriteRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
