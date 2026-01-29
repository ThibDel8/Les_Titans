<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Infrastructure\Doctrine\Repository;

use App\PublicApp\Contact\Domain\Repository\ContactMessageWriteRepositoryInterface;
use App\SharedKernel\Infrastructure\Doctrine\Repository\AbstractWriteRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContactMessageWriteRepository extends AbstractWriteRepository implements ContactMessageWriteRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }
}
