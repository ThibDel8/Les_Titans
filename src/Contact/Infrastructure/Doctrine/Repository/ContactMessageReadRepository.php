<?php

declare(strict_types=1);

namespace App\Contact\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Contact\Domain\Entity\ContactMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Admin\Contact\Domain\Repository\ContactMessageReadRepositoryInterface;

class ContactMessageReadRepository extends ServiceEntityRepository implements ContactMessageReadRepositoryInterface
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
        return $this->manager->getRepository(ContactMessage::class)->createQueryBuilder('m')
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllMessages(): array
    {
        return $this->manager->getRepository(ContactMessage::class)->findAll();
    }
}
