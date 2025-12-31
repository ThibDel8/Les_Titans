<?php

declare(strict_types=1);

namespace App\Repository\Member;

use App\Entity\Member\Member;
use Doctrine\Persistence\ManagerRegistry;
use App\Trait\Repository\WriteRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class MemberRepository extends ServiceEntityRepository
{
    use WriteRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }
}
