<?php

declare(strict_types=1);

namespace App\Enum\Security;

enum Role: string
{
    case Admin = 'ROLE_ADMIN';
    case President = 'ROLE_PRESIDENT';
    case VicePresident = 'ROLE_VICE_PRESIDENT';
    case Treasurer = 'ROLE_TREASURER';
    case Secretary = 'ROLE_SECRETARY';
    case Member = 'ROLE_MEMBER';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrateur',
            self::President => 'Président',
            self::VicePresident => 'Vice président',
            self::Treasurer => 'Trésorier',
            self::Secretary => 'Secrétaire',
            self::Member => 'Membre',
        };
    }
}
