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
        private string $appSlogan,
        private QrCodeGenerator $qrcodeGenerator,
        private ParameterBagInterface $parameterBag,
        private OpeningHoursProvider $openingHoursProvider,
    ) {
    }

    public function fetch(): OutdoorInfoSheetPdf
    {
        $appPublicUrl = $this->parameterBag->get('app.public.url');

        return OutdoorInfoSheetPdf::create(
            logoImage: $this->parameterBag->get('kernel.project_dir').'/public/images/logos/les_titans_image.png',
            logoText: $this->parameterBag->get('kernel.project_dir').'/public/images/logos/les_titans_text.png',
            schedules: $this->openingHoursProvider->getOpeningHours(),
            qrcode: $this->qrcodeGenerator->generate($appPublicUrl),
            slogan: $this->appSlogan,
        );
    }
}
