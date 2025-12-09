<?php

declare(strict_types=1);

namespace App\Enum\Membership;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    public function label(): string
    {
        return 'gender.' . $this->value;
    }
}
