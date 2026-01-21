<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Repository;

use App\Admin\User\Domain\Entity\User;

interface UserReadRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    /** @return User[] */
    public function findAllOrderedByFirstname(): array;

    /** @return User[] */
    public function findAllUsers(): array;

    public function findByPasswordToken(string $token): ?User;

    public function findPresident(): ?User;

    /** @return User[] */
    public function getBoardMembers(): array;
}
