<?php

declare(strict_types=1);

namespace App\PublicApp\Home\Domain\OpeningHours;

final class OpeningHours
{
    /**
     * @param OpeningDay[] $days
     */
    private function __construct(
        private array $days,
    ) {
    }

    public function getDays(): array
    {
        return $this->days;
    }

    public function getToday(): OpeningDay
    {
        $now = new \DateTimeImmutable();
        foreach ($this->days as $day) {
            if ($day->isToday($now)) {
                return $day;
            }
        }

        throw new \RuntimeException('Jour actuel non trouvé');
    }

    public function isOpenNow(): bool
    {
        return $this->getToday()->isOpenAt(new \DateTimeImmutable());
    }

    public function getNextOpeningDay(?\DateTimeImmutable $from = null): ?OpeningDay
    {

        $from ??= new \DateTimeImmutable();
        $todayKey = strtolower($from->format('l'));

        $keys = array_map(fn (OpeningDay $day) => $day->getKey(), $this->days);
        $todayIndex = array_search($todayKey, $keys, true);

        $daysCount = count($this->days);

        for ($i = 0; $i < $daysCount; ++$i) {
            $day = $this->days[($todayIndex + $i) % $daysCount];

            if ($day->isClosed()) {
                continue;
            }

            if ($day->isToday($from)) {
                if ($day->getOpeningTime() > $from->format('H:i')) {
                    return $day;
                }
                continue;
            }

            return $day;
        }

        return null;
    }

    public function getNextOpeningDayLabel(?\DateTimeImmutable $from = null): ?string
    {
        $from ??= new \DateTimeImmutable();
        $nextDay = $this->getNextOpeningDay($from);

        if (!$nextDay) {
            return null;
        }

        $today = $from->format('Y-m-d');
        $nextDate = $this->getDateOfDay($nextDay->getKey(), $from)->format('Y-m-d');

        return $nextDate === $today
            ? 'aujourd\'hui'
            : ($nextDate === $from->modify('+1 day')->format('Y-m-d')
                ? 'demain'
                : $nextDay->getLabel());
    }

    private function getDateOfDay(string $dayKey, \DateTimeImmutable $from): \DateTimeImmutable
    {
        $currentDayIndex = (int) $from->format('N');
        $targetDayIndex = match ($dayKey) {
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
            'sunday' => 7,
        };

        $diff = ($targetDayIndex - $currentDayIndex + 7) % 7;
        $diff = 0 === $diff ? 7 : $diff;

        return $from->modify("+{$diff} day");
    }

    public static function create(array $days): self
    {
        return new self(days: $days);
    }
}
