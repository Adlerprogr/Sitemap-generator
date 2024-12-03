<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap\Validators;

use Adlerprogr\GeneratingSiteMap\Contracts\ValidatorInterface;
use Adlerprogr\GeneratingSiteMap\Exception\InvalidDataException;

class SitemapValidator implements ValidatorInterface
{
    public function validate(array $pages): void
    {
        foreach ($pages as $page) {
            $this->validateRequiredFields($page);
            $this->validateUrl($page['loc']);
            $this->validateDate($page['lastmod']);
            $this->validatePriority($page['priority']);
            $this->validateChangefreq($page['changefreq']);
        }
    }

    private function validateRequiredFields(array $page): void
    {
        $required = ['loc', 'lastmod', 'priority', 'changefreq'];
        foreach ($required as $field) {
            if (!isset($page[$field])) {
                throw new InvalidDataException("Missing required field: {$field}");
            }
        }
    }

    private function validateUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidDataException("Invalid URL: {$url}");
        }
    }

    private function validateDate(string $date): void
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new InvalidDataException("Invalid date format: {$date}. Expected: YYYY-MM-DD");
        }
    }

    private function validatePriority($priority): void
    {
        if (!is_numeric($priority) || $priority < 0 || $priority > 1) {
            throw new InvalidDataException("Invalid priority: {$priority}. Must be between 0 and 1");
        }
    }

    private function validateChangefreq(string $freq): void
    {
        $allowed = ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];
        if (!in_array($freq, $allowed)) {
            throw new InvalidDataException("Invalid changefreq: {$freq}");
        }
    }
}