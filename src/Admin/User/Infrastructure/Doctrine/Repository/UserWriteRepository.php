<?php

declare(strict_types=1);

namespace App\Admin\User\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Admin\User\Domain\Repository\UserWriteRepositoryInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;

class UserWriteRepository extends AbstractWriteRepository implements UserWriteRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
