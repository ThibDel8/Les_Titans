<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Service\Utils\Formatter;

final class NameFormatter
{
    public static function format(string $name): string
    {
        $name = strtolower(trim($name));
        $name = implode('-', array_map('ucfirst', explode('-', $name)));
        $name = implode(' ', array_map('ucfirst', explode(' ', $name)));
        $name = implode(self::APOSTROPHE, array_map('ucfirst', explode(self::APOSTROPHE, $name)));

        return $name;
    }
}
