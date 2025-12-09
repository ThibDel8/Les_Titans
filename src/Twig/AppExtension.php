<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('fr_date', [$this, 'formatDateFr']),
        ];
    }

    public function formatDateFr(\DateTimeInterface $date): string
    {
        $jours = [
            'Sunday' => 'Dimanche',
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
        ];

        $mois = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre',
        ];

        $dayName = $jours[$date->format('l')];
        $monthName = $mois[$date->format('F')];
        return sprintf('%s %02d %s %d à %02d:%02d',
            $dayName,
            $date->format('d'),
            $monthName,
            $date->format('Y'),
            $date->format('H'),
            $date->format('i')
        );
    }
}
