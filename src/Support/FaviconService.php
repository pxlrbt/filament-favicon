<?php

namespace pxlrbt\FilamentFavicon\Support;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use pxlrbt\FilamentFavicon\Jobs\FetchFaviconJob;

class FaviconService
{
    protected const FAVICON_EXTENSIONS = ['.svg', '.png', '.ico', '.jpg'];

    protected const NOT_FOUND_EXTENSION = '.404';

    protected const ALL_EXTENSIONS = [...self::FAVICON_EXTENSIONS, self::NOT_FOUND_EXTENSION];

    protected function storage(): Filesystem
    {
        return Storage::disk(config('filament-favicon.storage.disk', 'public'));
    }

    protected function directory(): string
    {
        return rtrim(config('filament-favicon.storage.directory', 'favicons'), '/').'/';
    }

    protected function isStale(string $filename): bool
    {
        $lastModified = $this->storage()->lastModified($filename);
        $staleInterval = config('filament-favicon.stale_after', CarbonInterval::week(1));
        $staleDate = Carbon::createFromTimestamp($lastModified)->addSeconds($staleInterval->totalSeconds);

        return $staleDate->isPast();
    }

    protected function findFaviconFile(string $domain): ?string
    {
        foreach (self::FAVICON_EXTENSIONS as $extension) {
            $filename = $this->directory().$domain.$extension;

            if ($this->storage()->exists($filename)) {
                return $filename;
            }
        }

        return null;
    }

    public function getExtension(string $mimeType): string
    {
        return match ($mimeType) {
            'image/x-icon' => 'ico',
            'image/jpeg' => 'jpg',
            'image/svg+xml' => 'svg',
            default => 'png',
        };
    }

    public function clear(): void
    {
        $this->storage()->deleteDirectory($this->directory());
    }

    protected function pruneOldFiles(string $domain): void
    {
        foreach (self::ALL_EXTENSIONS as $extension) {
            $oldFile = $this->directory().$domain.$extension;

            if ($this->storage()->exists($oldFile)) {
                $this->storage()->delete($oldFile);
            }
        }
    }

    public function store(string $filename, string $content): void
    {
        $domain = pathinfo($filename, PATHINFO_FILENAME);

        $this->pruneOldFiles($domain);

        $this->storage()->put($this->directory().$filename, $content);
    }

    public function url(?string $domain): ?string
    {
        if ($domain === null) {
            return null;
        }

        $storage = $this->storage();
        $notFoundFile = $this->directory().$domain.self::NOT_FOUND_EXTENSION;

        if ($storage->exists($notFoundFile)) {
            if ($this->isStale($notFoundFile)) {
                dispatch(new FetchFaviconJob($domain));
            }

            return null;
        }

        $faviconFile = $this->findFaviconFile($domain);

        if ($faviconFile !== null) {
            if ($this->isStale($faviconFile)) {
                dispatch(new FetchFaviconJob($domain));
            }

            if ($storage->providesTemporaryUrls()) {
                return $storage->temporaryUrl(
                    $faviconFile,
                    now()->addMinutes(30),
                );
            }

            return $storage->url($faviconFile);
        }

        dispatch(new FetchFaviconJob($domain));

        return null;
    }
}
