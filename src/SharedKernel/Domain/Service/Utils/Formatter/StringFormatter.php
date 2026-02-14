<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Service\Utils\Formatter;

final class StringFormatter
{
    private const string UC_FIRST = 'ucfirst';

    public static function properNoun(string $name): string
    {
        $name = strtolower(trim($name));
        $name = implode('-', array_map(self::UC_FIRST, explode('-', $name)));
        $name = implode(' ', array_map(self::UC_FIRST, explode(' ', $name)));

        return implode("'", array_map(self::UC_FIRST, explode("'", $name)));
    }

    public static function address(string $address): string
    {
        $exceptions = [
            'le', 'la', 'les', "l'", 'du', 'de', 'des', 'au', 'aux', 'à', 'sur', 'sous', 'chez', 'par', 'et', '/'
        ];

        // trim + réduire les espaces multiples
        $address = preg_replace('/\s+/', ' ', trim($address));
        $address = mb_strtolower($address, 'UTF-8');

        $words = explode(' ', $address);
        foreach ($words as &$word) {
            // Gérer le slash
            $slashParts = explode('/', $word);
            foreach ($slashParts as &$slashPart) {
                // Gérer les tirets
                $dashParts = explode('-', $slashPart);
                foreach ($dashParts as &$part) {
                    // Gérer les exceptions
                    if (!in_array($part, $exceptions)) {
                        // majuscule pour la première lettre UTF-8
                        $first = mb_substr($part, 0, 1, 'UTF-8');
                        $rest  = mb_substr($part, 1, null, 'UTF-8');
                        $part = mb_strtoupper($first, 'UTF-8') . $rest;
                    }
                }
                $slashPart = implode('-', $dashParts);
            }
            $word = implode('/', $slashParts);
        }

        return implode(' ', $words);
    }
}
