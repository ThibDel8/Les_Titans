<?php

declare(strict_types=1);

namespace App\SharedKernel\Membership\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;
use App\SharedKernel\Membership\Domain\Repository\MembershipWriteRepositoryInterface;

class MembershipWriteRepository extends AbstractWriteRepository implements MembershipWriteRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
