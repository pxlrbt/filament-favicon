![header](./.github/resources/pxlrbt-favicon.png)


# Filament Favicon

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pxlrbt/filament-favicon.svg?include_prereleases)](https://packagist.org/packages/pxlrbt/filament-favicon)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/pxlrbt/filament-favicon/code-style.yml?branch=main&label=Code%20style&style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/pxlrbt/filament-favicon.svg)](https://packagist.org/packages/pxlrbt/filament-favicon)


## Installation via Composer

```bash
composer require pxlrbt/filament-favicon
```

## Features

### FaviconColumn

Display website favicons in your Filament table columns:

```php
use pxlrbt\FilamentFavicon\Filament\FaviconColumn;

FaviconColumn::make('website')
```

The column automatically fetches and caches favicons based on the domain value. The state must be a domain name (e.g., `example.com`).

If you need to extract the domain from a URL, use the `state()` method:

```php
FaviconColumn::make('website')
    ->state(fn ($record) => parse_url($record->website, PHP_URL_HOST))
```

### FaviconEntry

Display website favicons in your Filament infolists:

```php
use pxlrbt\FilamentFavicon\Filament\FaviconEntry;

FaviconEntry::make('website')
```

The entry automatically fetches and caches favicons based on the domain value. The state must be a domain name (e.g., `example.com`).

If you need to extract the domain from a URL, use the `state()` method:

```php
FaviconEntry::make('website')
    ->state(fn ($record) => parse_url($record->website, PHP_URL_HOST))
```

### Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=filament-favicon-config
```

Available options:

```php
return [
    // Favicon fetcher service (DuckDuckGo or IconHorse)
    'diver' => \pxlrbt\FilamentFavicon\Drivers\IconHorse::class,

    // How long to keep favicons before re-fetching
    'stale_after' => CarbonInterval::week(1),

    // Storage configuration
    'storage' => [
        'disk' => 'public',
        'directory' => 'favicons',
    ],
];
```

### Favicon Drivers

This package includes two favicon drivers:

**IconHorse** (default)
- Dedicated favicon service with enhanced reliability
- Free tier: up to 1,000 lookups per month
- Paid plans available for higher volumes
- Class: `\pxlrbt\FilamentFavicon\Drivers\IconHorse::class`
- 
**DuckDuckGo**
- Uses DuckDuckGo's search engine index to fetch favicons
- No rate limits or usage restrictions
- Free and unlimited
- Class: `\pxlrbt\FilamentFavicon\Drivers\DuckDuckGo::class`

To switch drivers, update the `driver` option in your config file.

### Clear Favicons

Clear all cached favicons:

```bash
php artisan favicons:clear
```


## Contributing

If you want to contribute to this packages, you may want to test it in a real Filament project:

- Fork this repository to your GitHub account.
- Create a Filament app locally.
- Clone your fork in your Filament app's root directory.
- In the `/filament-favicon` directory, create a branch for your fix, e.g. `fix/error-message`.

Install the packages in your app's `composer.json`:

```json
"require": {
    "pxlrbt/filament-favicon": "dev-fix/error-message as main-dev",
},
"repositories": [
    {
        "type": "path",
        "url": "filament-favicon"
    }
]
```

Now, run `composer update`.

## Credits
- [Dennis Koch](https://github.com/pxlrbt)
- [All Contributors](../../contributors)
