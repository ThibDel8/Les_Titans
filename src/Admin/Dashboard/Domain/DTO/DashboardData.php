<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Domain\DTO;

class DashboardData
{
    private function __construct(
        public int $nbUsers,
        public int $nbContactMessages,
        public int $nbMemberships,
        public array $logs,
    ) {
    }

    public static function create(
        int $nbUsers,
        int $nbContactMessages,
        int $nbMemberships,
        array $logs,
    ): self {
        return new self(
            nbUsers: $nbUsers,
            nbContactMessages: $nbContactMessages,
            nbMemberships: $nbMemberships,
            logs: $logs,
        );
    }
}
