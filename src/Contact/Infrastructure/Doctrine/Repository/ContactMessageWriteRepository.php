<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Contact\Domain\Repository\ContactMessageWriteRepositoryInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;

class ContactMessageWriteRepository extends AbstractWriteRepository implements ContactMessageWriteRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
