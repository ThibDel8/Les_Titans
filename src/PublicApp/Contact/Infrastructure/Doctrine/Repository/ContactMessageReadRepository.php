<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Infrastructure\Doctrine\Repository;

use App\Admin\Contact\Domain\Repository\ContactMessageReadRepositoryInterface;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\PublicApp\Contact\Domain\Enum\ContactMessageStatus;
use Doctrine\ORM\EntityManagerInterface;

readonly class ContactMessageReadRepository implements ContactMessageReadRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
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

    public function findUnreadContactMessages(): array
    {
        return $this->manager->getRepository(ContactMessage::class)->createQueryBuilder('m')
            ->where('m.status = :status')
            ->setParameter('status', ContactMessageStatus::NEW)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
