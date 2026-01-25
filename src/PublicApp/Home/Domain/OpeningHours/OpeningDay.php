<?php

declare(strict_types=1);

namespace App\PublicApp\Home\Domain\OpeningHours;

use App\PublicApp\Home\Domain\OpeningHours\TimeRange;

final class OpeningDay
{
    private function __construct(
        private string $key,
        private string $label,
        private ?TimeRange $range = null,
    ) {
    }

    public function isClosed(): bool
    {
        return $this->range === null;
    }

    public function isOpenAt(\DateTimeImmutable $time): bool
    {
        if ($this->range === null) {
            return false;
        }

        return $this->range->contains($time);
    }

    public function isToday(?\DateTimeImmutable $now = null): bool
    {
        $now ??= new \DateTimeImmutable();
        return strtolower($now->format('l')) === $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getRangeAsString(): string
    {
        return $this->range?->toHumanString() ?? 'Fermé';
    }

    public function getClosingTime(): ?string
    {
        return $this->range?->getEnd();
    }

    public function getOpeningTime(): ?string
    {
        return $this->range?->getStart();
    }

    public static function create(
        string $key,
        string $label,
        ?TimeRange $range = null,
    ): self
    {
        return new self(
            key: $key,
            label: $label,
            range: $range,
        );
    }
}
