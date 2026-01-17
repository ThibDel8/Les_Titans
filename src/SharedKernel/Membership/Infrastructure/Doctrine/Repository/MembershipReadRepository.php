<?php

declare(strict_types=1);

namespace App\SharedKernel\Membership\Infrastructure\Doctrine\Repository;

use App\SharedKernel\Membership\Domain\Entity\Membership;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\SharedKernel\Membership\Domain\Repository\MembershipReadRepositoryInterface;

class MembershipReadRepository extends ServiceEntityRepository implements MembershipReadRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }

    public function findAllOrdererByCreatedAt(): array
    {
        return $this->manager->getRepository(Membership::class)->findBy([], ['createdAt' => 'DESC']);
    }

    public function findAllMemberships(): array
    {
        return $this->manager->getRepository(Membership::class)->findAll();
    }
}
