<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Service\Schedules\OpeningHours;

final class TimeRange
{
    private function __construct(
        private string $start,
        private string $end,
    ) {
    }

    public function contains(\DateTimeImmutable $time): bool
    {
        $current = $time->format('H:i');

        return $current >= $this->start && $current < $this->end;
    }

    public function toHumanString(): string
    {
        return sprintf('%s – %s', $this->start, $this->end);
    }

    public function getStart(): string
    {
        return $this->start;
    }

    public function getEnd(): string
    {
        return $this->end;
    }

    public static function create(
        string $start,
        string $end,
    ): self {
        return new self(
            start: $start,
            end: $end,
        );
    }
}
