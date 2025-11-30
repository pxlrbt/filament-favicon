<?php

namespace pxlrbt\FilamentFavicon\Drivers;

interface FaviconFetcher
{
    public function fetch(string $domain): void;
}
