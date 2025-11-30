<?php

use Carbon\CarbonInterval;
use pxlrbt\FilamentFavicon\FaviconFetchers\DuckDuckGo;

return [
    'fetcher' => DuckDuckGo::class,
    'stale_after' => CarbonInterval::week(1),

    'storage' => [
        'disk' => 'public',
        'directory' => 'favicons',
    ],
];
