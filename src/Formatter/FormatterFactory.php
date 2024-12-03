<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Formatter;

use Adlerprogr\GeneratingSiteMap\Contracts\FormatterInterface;
use Adlerprogr\GeneratingSiteMap\Exception\UnsupportedFormatException;

class FormatterFactory
{
    public function createFormatter(string $format): FormatterInterface
    {
        return match ($format) {
            'xml' => new XmlFormatter(),
            'csv' => new CsvFormatter(),
            'json' => new JsonFormatter(),
            default => throw new UnsupportedFormatException("Unsupported format: {$format}")
        };
    }
}