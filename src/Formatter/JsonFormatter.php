<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Formatter;

use Adlerprogr\GeneratingSiteMap\Contracts\FormatterInterface;

class JsonFormatter implements FormatterInterface
{
    public function format(array $pages): string
    {
        return json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}