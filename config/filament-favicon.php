<?php

use Carbon\CarbonInterval;
use pxlrbt\FilamentFavicon\Drivers\IconHorse;

return [
    'driver' => IconHorse::class,
    'stale_after' => CarbonInterval::week(1),
    'not_found_stale_after' => CarbonInterval::day(1),

    'storage' => [
        'disk' => 'public',
        'directory' => 'favicons',
    ],
];
