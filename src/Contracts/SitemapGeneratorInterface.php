<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Contracts;

interface SitemapGeneratorInterface
{
    public function generate(): void;
}