<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Enum;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    public function label(): string
    {
        return 'gender.'.$this->value;
    }
}
