<?php

namespace pxlrbt\FilamentFavicon;

use pxlrbt\FilamentFavicon\Commands\ClearFaviconsCommand;
use pxlrbt\FilamentFavicon\Drivers\FaviconFetcher;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFaviconServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-favicon';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasCommand(ClearFaviconsCommand::class)
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(FaviconFetcher::class, config('filament-favicon.driver'));
    }
}
