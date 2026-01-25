<?php

declare(strict_types=1);

namespace App\PublicApp\Home\Domain\Service;

use App\PublicApp\Home\Domain\OpeningHours\TimeRange;
use App\PublicApp\Home\Domain\OpeningHours\OpeningDay;
use App\PublicApp\Home\Domain\OpeningHours\OpeningHours;

final class OpeningHoursProvider
{
    public function getOpeningHours(): OpeningHours
    {
        return OpeningHours::create([
            OpeningDay::create(
                key: 'monday',
                label: 'Lundi',
                range: TimeRange::create(
                    start: '07:00',
                    end: '22:00'
                ),
            ),
            OpeningDay::create(
                key: 'tuesday',
                label: 'Mardi',
                range: TimeRange::create(
                    start: '07:00',
                    end: '22:00'
                ),
            ),
            OpeningDay::create(
                key: 'wednesday',
                label: 'Mercredi',
                range: TimeRange::create(
                    start: '07:00',
                    end: '22:00'
                ),
            ),
            OpeningDay::create(
                key: 'thursday',
                label: 'Jeudi',
                range: TimeRange::create(
                    start: '07:00',
                    end: '22:00'
                ),
            ),
            OpeningDay::create(
                key: 'friday',
                label: 'Vendredi',
                range: TimeRange::create(
                    start: '07:00',
                    end: '22:00'
                ),
            ),
            OpeningDay::create(
                key: 'saturday',
                label: 'Samedi',
                range: TimeRange::create(
                    start: '07:00',
                    end: '22:00'
                ),
            ),
            OpeningDay::create(
                key: 'sunday',
                label: 'Dimanche',
                range: TimeRange::create(
                    start: '07:00',
                    end: '22:00'
                ),
            ),
        ]);
    }
}
