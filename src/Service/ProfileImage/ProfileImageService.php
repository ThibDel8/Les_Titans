<?php

declare(strict_types=1);

namespace App\Service\ProfileImage;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProfileImageService
{
    public const string FEMALE_PROFILE = 'female_default_profile.png';
    public const string MALE_PROFILE = 'male_default_profile.png';
    public const string OTHER_PROFILE = 'other_default_profile.png';
    public const array ALL_PROFILES = [
        self::FEMALE_PROFILE,
        self::MALE_PROFILE,
        self::OTHER_PROFILE,
    ];

    public function __construct(
        #[Autowire('%kernel.project_dir%/public/images/profiles/')]
        private string $profileImageDir
    ) {
    }

    public function save(string $originalPath): string
    {
        $imageInfo = getimagesize($originalPath);

        if ($imageInfo === false || !isset($imageInfo['mime'])) {
            throw new \RuntimeException('Fichier image invalide.');
        }
        $mime = $imageInfo['mime'];

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($originalPath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($originalPath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($originalPath);
                break;
            case 'image/bmp':
            case 'image/x-ms-bmp':
                $image = imagecreatefrombmp($originalPath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($originalPath);
                break;
            case 'image/vnd.wap.wbmp':
                $image = imagecreatefromwbmp($originalPath);
                break;
            default:
                throw new \InvalidArgumentException('Format d’image non supporté.');
        }

        $newFilename = bin2hex(random_bytes(16)) . '.png';

        imagepng($image, $this->profileImageDir . $newFilename);
        unset($image);

        return $newFilename;
    }

    public function remove(string $profileImage): void
    {
        if (in_array($profileImage, self::ALL_PROFILES, true)) {
            return;
        }

        $filePath = rtrim($this->profileImageDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $profileImage;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function update(string $newImagePath, string $oldImagePath): string
    {
        $this->remove($oldImagePath);

        return $this->save($newImagePath);
    }
}
