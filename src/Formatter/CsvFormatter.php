<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Formatter;

use Adlerprogr\GeneratingSiteMap\Contracts\FormatterInterface;

class CsvFormatter implements FormatterInterface
{
    public function format(array $pages): string
    {
        $output = "loc;lastmod;priority;changefreq\n";

        foreach ($pages as $page) {
            $output .= sprintf(
                "%s;%s;%s;%s\n",
                $page['loc'],
                $page['lastmod'],
                $page['priority'],
                $page['changefreq']
            );
        }

        return $output;
    }
}