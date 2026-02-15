<?php

declare(strict_types=1);

namespace App\Admin\Document\Domain\QueryHandler;

use App\Admin\Document\Domain\DTO\Pdf\OutdoorInfoSheetPdf;
use App\SharedKernel\Domain\Service\QrCode\QrCodeGenerator;
use App\SharedKernel\Domain\Service\Schedules\OpeningHoursProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

readonly class OutdoorInfoSheetQuery
{
    public function __construct(
        private QrCodeGenerator $qrcodeGenerator,
        private ParameterBagInterface $parameterBag,
        private OpeningHoursProvider $openingHoursProvider,
    ) {
    }

    public function fetch(): OutdoorInfoSheetPdf
    {
        return OutdoorInfoSheetPdf::create(
            logo: $this->parameterBag->get('kernel.project_dir').'/public/images/logos/les_titans_image.png',
            schedules: $this->openingHoursProvider->getOpeningHours(),
            qrcode: $this->qrcodeGenerator->generate('https://www.google.com'),
            slogan: $this->parameterBag->get('app.slogan'),
        );
    }
}
