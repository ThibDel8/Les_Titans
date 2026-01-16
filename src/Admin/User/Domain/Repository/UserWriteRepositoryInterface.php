<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Repository;

use App\Admin\User\Domain\Entity\User;

interface UserWriteRepositoryInterface
{
    public function save(User $user, bool $flush = true): void;

    public function delete(User $user, bool $flush = true): void;
}
