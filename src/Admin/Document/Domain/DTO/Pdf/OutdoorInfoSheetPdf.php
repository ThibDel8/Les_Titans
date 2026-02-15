<?php

declare(strict_types=1);

namespace App\Admin\Document\Domain\DTO\Pdf;

use App\SharedKernel\Domain\Service\Schedules\OpeningHours\OpeningHours;

class OutdoorInfoSheetPdf
{
    public function __construct(
        public string $logoImage,
        public string $logoText,
        public OpeningHours $schedules,
        public string $qrcode,
        public string $slogan,
    ) {
    }

    public static function create(
        string $logoImage,
        string $logoText,
        OpeningHours $schedules,
        string $qrcode,
        string $slogan,
    ): self {
        return new self(
            logoImage: $logoImage,
            logoText: $logoText,
            schedules: $schedules,
            qrcode: $qrcode,
            slogan: $slogan,
        );
    }
}
