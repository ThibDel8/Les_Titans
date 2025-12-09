<?php

declare(strict_types=1);

namespace App\Repository\Membership;

use App\Entity\Membership\Membership;
use Doctrine\Persistence\ManagerRegistry;
use App\Trait\Repository\WriteRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class MembershipRepository extends ServiceEntityRepository
{
    use WriteRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membership::class);
    }
}
