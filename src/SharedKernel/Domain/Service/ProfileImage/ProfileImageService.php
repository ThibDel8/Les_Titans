<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Service\ProfileImage;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProfileImageService
{
    public const string FEMALE_PROFILE = 'female_default_profile.png';
    public const string MALE_PROFILE = 'male_default_profile.png';
    public const string OTHER_PROFILE = 'other_default_profile.png';
    public const string ADMIN_PROFILE = 'admin_default_profile.png';

    public function __construct(
        #[Autowire('%kernel.project_dir%/public/images/profiles/uploads/')]
        private string $uploadsDir,
        #[Autowire('%kernel.project_dir%/public/images/profiles/defaults/')]
        private string $defaultsDir
    ) {
        if (!is_dir($this->uploadsDir)) {
            mkdir($this->uploadsDir, 0775, true);
        }

        if (!is_writable($this->uploadsDir)) {
            throw new \RuntimeException('Le dossier ' . $this->uploadsDir . ' n’est pas accessible en écriture.');
        }
    }

    public function save(string $originalPath): string
    {
        if (!file_exists($originalPath)) {
            throw new \RuntimeException('Le fichier source ' . $originalPath . ' n’existe pas.');
        }

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

        imagepng($image, $this->uploadsDir . $newFilename);
        unset($image);

        return $newFilename;
    }

    public function remove(string $profileImage): void
    {
        $filePath = rtrim($this->uploadsDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $profileImage;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function update(string $newImagePath, string $oldImagePath): string
    {
        $this->remove($oldImagePath);

        return $this->save($newImagePath);
    }
    public function getDefaultsDir(): string
    {
        return $this->defaultsDir;
    }
}
