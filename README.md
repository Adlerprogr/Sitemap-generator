# Sitemap Generator Library

Библиотека для генерации карты сайта в форматах XML, CSV и JSON. Разработана с соблюдением SOLID принципов и предоставляет гибкий интерфейс для создания файлов sitemap.

## Установка

Установите пакет через Composer:

```bash
composer require adlerprogr/generating-site-map
```

## Требования

- PHP 8.2 или выше

## Использование

### Базовый пример

```php
use Adlerprogr\GeneratingSiteMap\SitemapGenerator;

$pages = [
    [
        'loc' => 'https://site.ru/',
        'lastmod' => '2024-03-12',
        'priority' => 1,
        'changefreq' => 'hourly'
    ],
    [
        'loc' => 'https://site.ru/about',
        'lastmod' => '2024-03-12',
        'priority' => 0.8,
        'changefreq' => 'weekly'
    ]
];

$generator = new SitemapGenerator(
    pages: $pages,
    format: 'xml',
    filePath: '/path/to/sitemap.xml'
);
$generator->generate();
```

### Поддерживаемые форматы

1. XML
```php
$generator = new SitemapGenerator($pages, 'xml', 'sitemap.xml');
```

2. CSV
```php
$generator = new SitemapGenerator($pages, 'csv', 'sitemap.csv');
```

3. JSON
```php
$generator = new SitemapGenerator($pages, 'json', 'sitemap.json');
```

### Структура данных страниц

Каждая страница должна содержать следующие поля:

- `loc` (string): URL страницы
- `lastmod` (string): Дата последнего изменения в формате YYYY-MM-DD
- `priority` (float): Приоритет от 0 до 1
- `changefreq` (string): Частота изменения (always, hourly, daily, weekly, monthly, yearly, never)

### Примеры форматов вывода

#### XML
```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>https://site.ru/</loc>
        <lastmod>2024-03-12</lastmod>
        <priority>1</priority>
        <changefreq>hourly</changefreq>
    </url>
</urlset>
```

#### CSV
```csv
loc;lastmod;priority;changefreq
https://site.ru/;2024-03-12;1;hourly
https://site.ru/about;2024-03-12;0.8;weekly
```

#### JSON
```json
[
    {
        "loc": "https://site.ru/",
        "lastmod": "2024-03-12",
        "priority": 1,
        "changefreq": "hourly"
    },
    {
        "loc": "https://site.ru/about",
        "lastmod": "2024-03-12",
        "priority": 0.8,
        "changefreq": "weekly"
    }
]
```

## Интеграция с Laravel

### Пример контроллера

```php
<?php

namespace App\Http\Controllers;

use Adlerprogr\GeneratingSiteMap\SitemapGenerator;
use Illuminate\Http\JsonResponse;

class TestSitemapController extends Controller
{
    public function test(): JsonResponse
    {
        try {
            $pages = [
                [
                    'loc' => 'https://example.com',
                    'lastmod' => '2024-03-12',
                    'priority' => 1,
                    'changefreq' => 'daily'
                ],
                [
                    'loc' => 'https://example.com/about',
                    'lastmod' => '2024-03-12',
                    'priority' => 0.8,
                    'changefreq' => 'weekly'
                ]
            ];

            // Тестируем XML формат
            $xmlGenerator = new SitemapGenerator(
                pages: $pages,
                format: 'xml',
                filePath: storage_path('app/public/sitemap.xml')
            );
            $xmlGenerator->generate();

            // Тестируем CSV формат
            $csvGenerator = new SitemapGenerator(
                pages: $pages,
                format: 'csv',
                filePath: storage_path('app/public/sitemap.csv')
            );
            $csvGenerator->generate();

            // Тестируем JSON формат
            $jsonGenerator = new SitemapGenerator(
                pages: $pages,
                format: 'json',
                filePath: storage_path('app/public/sitemap.json')
            );
            $jsonGenerator->generate();

            return response()->json([
                'success' => true,
                'message' => 'All sitemaps generated successfully',
                'files' => [
                    'xml' => asset('storage/sitemap.xml'),
                    'csv' => asset('storage/sitemap.csv'),
                    'json' => asset('storage/sitemap.json')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
```

### Artisan команда

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Adlerprogr\GeneratingSiteMap\SitemapGenerator;

class TestSitemap extends Command
{
    protected $signature = 'sitemap:test';
    protected $description = 'Test sitemap generator package';

    public function handle(): void
    {
        $this->info('Testing sitemap generator...');

        try {
            $pages = [
                [
                    'loc' => 'https://example.com',
                    'lastmod' => date('Y-m-d'),
                    'priority' => 1,
                    'changefreq' => 'daily'
                ]
            ];

            foreach (['xml', 'csv', 'json'] as $format) {
                $filePath = storage_path("app/public/sitemap.{$format}");

                $generator = new SitemapGenerator($pages, $format, $filePath);
                $generator->generate();

                $this->info("Generated {$format} sitemap: {$filePath}");
            }

            $this->info('Все карты сайта созданы успешно!');

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
```

## Обработка ошибок

Библиотека выбрасывает следующие исключения:

- `InvalidDataException`: Невалидные данные страниц
- `FileAccessException`: Ошибка доступа к файлу
- `UnsupportedFormatException`: Неподдерживаемый формат файла

Пример обработки ошибок:

```php
try {
    $generator = new SitemapGenerator($pages, 'xml', 'sitemap.xml');
    $generator->generate();
} catch (InvalidDataException $e) {
    // Обработка невалидных данных
} catch (FileAccessException $e) {
    // Обработка ошибок доступа к файлу
} catch (UnsupportedFormatException $e) {
    // Обработка неподдерживаемого формата
}
```

## Тестирование

Для запуска тестов:

```bash
php artisan sitemap:test
```

## Автор

- **[adlerprogr](https://github.com/adlerprogr)**

# Sitemap-generator


