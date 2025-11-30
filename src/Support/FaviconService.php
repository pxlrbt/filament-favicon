<?php

namespace pxlrbt\FilamentFavicon\Support;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Uri;
use pxlrbt\FilamentFavicon\Jobs\FetchFaviconJob;

class FaviconService
{
    protected function storage(): Filesystem
    {
        return Storage::disk(config('filament-favicon.storage.disk', 'public'));
    }

    protected function directory(): string
    {
        return rtrim(config('filament-favicon.storage.directory', 'favicons'), '/').'/';
    }

    public function getExtension(string $mimeType): string
    {
        return match ($mimeType) {
            'image/x-icon' => 'ico',
            'image/jpg', 'image/jpeg' => 'jpg',
            'image/svg+xml' => 'svg',
            default => 'png',
        };
    }

    public function clear(): void
    {
        $this->storage()->deleteDirectory($this->directory());
    }

    public function store(string $filename, string $content): void
    {
        $domain = pathinfo($filename, PATHINFO_FILENAME);
        $allExtensions = ['.svg', '.png', '.ico', '.jpg', '.404'];

        foreach ($allExtensions as $extension) {
            $oldFile = $this->directory().$domain.$extension;

            if ($this->storage()->exists($oldFile)) {
                $this->storage()->delete($oldFile);
            }
        }

        $this->storage()->put($this->directory().$filename, $content);
    }

    public function url($state): ?string
    {
        if ($state === null) {
            return null;
        }

        $domain = $state;

        if ($domain === null) {
            return null;
        }

        $filename = $this->directory().$domain.'.404';

        if ($this->storage()->exists($filename)) {
            $lastModified = $this->storage()->lastModified($filename);

            $staleInterval = config('filament-favicon.stale_after', CarbonInterval::week(1));
            $staleDate = Carbon::createFromTimestamp($lastModified)->addSeconds($staleInterval->totalSeconds);

            if ($staleDate->isPast()) {
                dispatch(new FetchFaviconJob($domain));
            }

            return null;
        }

        $possibleExtensions = ['.svg', '.png', '.ico', '.jpg'];

        foreach ($possibleExtensions as $extension) {
            $filename = $this->directory().$domain.$extension;

            if ($this->storage()->exists($filename)) {
                $lastModified = $this->storage()->lastModified($filename);

                $staleInterval = config('filament-favicon.stale_after', CarbonInterval::week(1));
                $staleDate = Carbon::createFromTimestamp($lastModified)->addSeconds($staleInterval->totalSeconds);

                if ($staleDate->isPast()) {
                    dispatch(new FetchFaviconJob($domain));
                }

                return $this->storage()->url($filename);
            }
        }

        dispatch(new FetchFaviconJob($domain));

        return null;
    }
}
