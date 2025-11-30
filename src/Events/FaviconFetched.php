<?php

namespace pxlrbt\FilamentFavicon\Events;

class FaviconFetched
{
    public function __construct(
        public string $domain,
    ) {}
}
