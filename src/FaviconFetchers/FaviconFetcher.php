<?php

namespace pxlrbt\FilamentFavicon\FaviconFetchers;

interface FaviconFetcher
{
    public function fetch(string $domain): void;
}
