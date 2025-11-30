<?php

namespace pxlrbt\FilamentFavicon\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use pxlrbt\FilamentFavicon\FaviconFetchers\FaviconFetcher;

class FetchFaviconJob implements ShouldBeUnique, ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 1;

    public function __construct(
        protected string $domain,
    ) {}

    public function uniqueId(): string
    {
        return $this->domain;
    }

    public function handle(FaviconFetcher $faviconFetcher): void
    {
        $faviconFetcher->fetch($this->domain);
    }
}
