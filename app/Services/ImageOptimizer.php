<?php

namespace App\Services;

class ImageOptimizer
{
    /**
     * Resize and optimize an image file.
     *
     * @param string $sourcePath Full path to source image
     * @param string|null $destinationPath Destination path (defaults to sourcePath if null)
     * @param int $maxWidth Maximum width in pixels
     * @param int $maxHeight Maximum height in pixels
     * @param int $quality JPEG/WebP compression quality (0-100)
     * @return bool True on success, false on failure
     */
    public static function optimize(
        string $sourcePath,
        ?string $destinationPath = null,
        int $maxWidth = 800,
        int $maxHeight = 1000,
        int $quality = 82
    ): bool {
        if (!file_exists($sourcePath) || !is_readable($sourcePath)) {
            return false;
        }

        $destinationPath = $destinationPath ?? $sourcePath;

        $info = @getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        [$width, $height, $type] = $info;

        // Load image based on MIME type
        $image = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => @imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false,
            default => false,
        };

        if (!$image) {
            return false;
        }

        // Calculate new dimensions preserving aspect ratio
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = (int) round($width * $ratio);
            $newHeight = (int) round($height * $ratio);
        }

        // Create canvas
        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        // Handle transparency for PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
            imagefilledrectangle($canvas, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resample with high quality interpolation
        imagecopyresampled(
            $canvas,
            $image,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );

        // Save optimized image
        $success = match ($type) {
            IMAGETYPE_JPEG => imagejpeg($canvas, $destinationPath, $quality),
            IMAGETYPE_PNG => imagepng($canvas, $destinationPath, 7), // 0-9 compression level
            IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($canvas, $destinationPath, $quality) : false,
            default => false,
        };

        return $success;
    }
}
