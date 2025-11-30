<?php

use Carbon\CarbonInterval;
use pxlrbt\FilamentFavicon\Drivers\IconHorse;

return [
    'driver' => IconHorse::class,
    'stale_after' => CarbonInterval::week(1),

    'storage' => [
        'disk' => 'public',
        'directory' => 'favicons',
    ],
];
