<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Formatter;

use Adlerprogr\GeneratingSiteMap\Contracts\FormatterInterface;

class XmlFormatter implements FormatterInterface
{
    /**
     * @throws \Exception
     */
    public function format(array $pages): string
    {
        $xml = new \SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?>' .
            '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
            'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ' .
            'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ' .
            'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"/>'
        );

        foreach ($pages as $page) {
            $url = $xml->addChild('url');
            foreach ($page as $key => $value) {
                $url->addChild($key, (string)$value);
            }
        }

        return $xml->asXML();
    }
}