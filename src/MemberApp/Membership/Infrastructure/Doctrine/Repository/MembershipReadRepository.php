<?php

declare(strict_types=1);

namespace App\MemberApp\Membership\Infrastructure\Doctrine\Repository;

use App\MemberApp\Membership\Domain\Entity\Membership;
use App\MemberApp\Membership\Domain\Repository\MembershipReadRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class MembershipReadRepository extends ServiceEntityRepository implements MembershipReadRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
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
