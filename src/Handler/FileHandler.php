<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Handler;

use Adlerprogr\GeneratingSiteMap\Exception\FileAccessException;

class FileHandler
{
    public function write(string $path, string $content): void
    {
        $dir = dirname($path);

        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new FileAccessException("Unable to create directory: {$dir}");
            }
        }

        if (!is_writable($dir) || (file_exists($path) && !is_writable($path))) {
            throw new FileAccessException("Path is not writable: {$path}");
        }

        if (file_put_contents($path, $content) === false) {
            throw new FileAccessException("Failed to write to file: {$path}");
        }
    }
}