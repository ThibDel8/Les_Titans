<?php

declare(strict_types=1);

namespace App\Enum\Security;

enum Role: string
{
    case Admin = 'ROLE_ADMIN';
    case Manager = 'ROLE_MANAGER';
    case Member = 'ROLE_MEMBER';
}
