<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Contracts;

interface FormatterInterface
{
    public function format(array $pages): string;
}