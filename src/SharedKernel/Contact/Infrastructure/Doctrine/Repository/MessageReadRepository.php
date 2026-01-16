<?php

declare(strict_types=1);

namespace App\SharedKernel\Contact\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\SharedKernel\Contact\Domain\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\SharedKernel\Contact\Domain\Repository\MessageReadRepositoryInterface;

class MessageReadRepository extends ServiceEntityRepository implements MessageReadRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }

    public function findAllOrderedByDate(): array
    {
        return $this->manager->getRepository(Message::class)->createQueryBuilder('m')
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllMessages(): array
    {
        return $this->manager->getRepository(Message::class)->findAll();
    }
}
