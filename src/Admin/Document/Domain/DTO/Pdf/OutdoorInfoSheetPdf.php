<?php

declare(strict_types=1);

namespace App\Admin\Document\Domain\DTO\Pdf;

use App\SharedKernel\Domain\Service\Schedules\OpeningHours\OpeningHours;

class OutdoorInfoSheetPdf
{
    public function __construct(
        public string $logo,
        public OpeningHours $schedules,
        public string $qrcode,
        public string $slogan,
    ) {
    }

    public static function create(
        string $logo,
        OpeningHours $schedules,
        string $qrcode,
        string $slogan,
    ): self {
        return new self(
            logo: $logo,
            schedules: $schedules,
            qrcode: $qrcode,
            slogan: $slogan,
        );
    }
}
