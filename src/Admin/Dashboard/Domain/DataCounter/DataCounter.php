<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Domain\DataCounter;

class DataCounter
{
    private function __construct(
        public int $nbUsers,
        public int $nbContactMessages,
        public int $nbMemberships,
    ) {
    }

    public static function create(
        int $nbUsers,
        int $nbContactMessages,
        int $nbMemberships,
    ): self {
        return new self(
            nbUsers: $nbUsers,
            nbContactMessages: $nbContactMessages,
            nbMemberships: $nbMemberships,
        );
    }
}
