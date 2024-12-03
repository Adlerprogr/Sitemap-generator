<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Contracts;

interface ValidatorInterface
{
    public function validate(array $pages): void;
}