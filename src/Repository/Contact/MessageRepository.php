<?php

declare(strict_types=1);

namespace App\Repository\Contact;

use App\Entity\Contact\Message;
use Doctrine\Persistence\ManagerRegistry;
use App\Trait\Repository\WriteRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class MessageRepository extends ServiceEntityRepository
{
    use WriteRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
