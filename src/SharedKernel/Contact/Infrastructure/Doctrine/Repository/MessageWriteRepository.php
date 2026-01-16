<?php

declare(strict_types=1);

namespace App\SharedKernel\Contact\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\SharedKernel\Contact\Domain\Repository\MessageWriteRepositoryInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;

class MessageWriteRepository extends AbstractWriteRepository implements MessageWriteRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
