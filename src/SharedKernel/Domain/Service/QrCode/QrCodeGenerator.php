<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Service\QrCode;

use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Eye\ModuleEye;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Module\RoundnessModule;
use BaconQrCode\Renderer\RendererStyle\EyeFill;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

final class QrCodeGenerator
{
    public function generate(string $url): string
    {
        $rendererStyle = new RendererStyle(
            size: 300,
            margin: 1,
            module: new RoundnessModule(0.4),
            eye: new ModuleEye(new RoundnessModule(0.9)),
            fill: Fill::withForegroundColor(
                backgroundColor: new Rgb(245, 245, 245),
                foregroundColor: new Rgb(28, 28, 28),
                topLeftEyeFill: EyeFill::uniform(new Rgb(182, 136, 42)),
                topRightEyeFill: EyeFill::uniform(new Rgb(182, 136, 42)),
                bottomLeftEyeFill: EyeFill::uniform(new Rgb(182, 136, 42)),
            ),
        );
        $imageBackEnd = new ImagickImageBackEnd(imageFormat: 'png', compressionQuality: 100);
        $renderer = new ImageRenderer(rendererStyle: $rendererStyle, imageBackEnd: $imageBackEnd);
        $writer = new Writer($renderer);

        return $writer->writeString($url);
    }
}
