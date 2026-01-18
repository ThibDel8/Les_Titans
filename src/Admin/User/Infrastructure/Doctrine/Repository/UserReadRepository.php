<?php

declare(strict_types=1);

namespace App\Admin\User\Infrastructure\Doctrine\Repository;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use Doctrine\ORM\EntityManagerInterface;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserReadRepository extends ServiceEntityRepository implements UserReadRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    protected function getManager(): EntityManagerInterface
    {
        return $this->manager;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function findAllOrderedByFirstname(): array
    {
        return $this->manager->getRepository(User::class)->findBy([], ['firstname' => 'ASC']);
    }

    public function findAllUsers(): array
    {
        return $this->manager->getRepository(User::class)->findAll();
    }

    public function findByPasswordToken(string $token): ?User
    {
        return $this->manager->getRepository(User::class)->findOneBy(['passwordSetupToken' => $token]);
    }

    public function findPresident(): ?User
    {
        return $this->manager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->andWhere("u.roles LIKE :role")
            ->setParameter('role', '%"'.Role::President->value.'"%')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
