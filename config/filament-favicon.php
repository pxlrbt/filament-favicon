<?php

use Carbon\CarbonInterval;
use pxlrbt\FilamentFavicon\FaviconFetchers\DuckDuckGo;
use pxlrbt\FilamentFavicon\FaviconFetchers\IconHorse;

return [
    'fetcher' => DuckDuckGo::class,
    'stale_after' => CarbonInterval::week(1),

    'storage' => [
        'disk' => 'public',
        'directory' => 'favicons',
    ],
];
