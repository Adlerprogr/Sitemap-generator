<?php

declare(strict_types=1);

namespace Adlerprogr\GeneratingSiteMap;

use Adlerprogr\GeneratingSiteMap\Exception\UnsupportedFormatException;
use Adlerprogr\GeneratingSiteMap\Handler\FileHandler;
use Adlerprogr\GeneratingSiteMap\Validators\SitemapValidator;
use Adlerprogr\GeneratingSiteMap\Formatter\FormatterFactory;
use Adlerprogr\GeneratingSiteMap\Contracts\FormatterInterface;
use Adlerprogr\GeneratingSiteMap\Contracts\SitemapGeneratorInterface;
use Adlerprogr\GeneratingSiteMap\Contracts\ValidatorInterface;

class SitemapGenerator implements SitemapGeneratorInterface
{
    private FormatterInterface $formatter;
    private ValidatorInterface $validator;
    private FileHandler $fileHandler;
    private array $pages;
    private string $filePath;

    /**
     * @throws UnsupportedFormatException
     */
    public function __construct(
        array $pages,
        string $format,
        string $filePath,
        ?ValidatorInterface $validator = null,
        ?FileHandler $fileHandler = null
    ) {
        $this->pages = $pages;
        $this->filePath = $filePath;
        $this->formatter = (new FormatterFactory())->createFormatter($format);
        $this->validator = $validator ?? new SitemapValidator();
        $this->fileHandler = $fileHandler ?? new FileHandler();

        $this->validator->validate($this->pages);
    }

    public function generate(): void
    {
        $content = $this->formatter->format($this->pages);
        $this->fileHandler->write($this->filePath, $content);
    }
}