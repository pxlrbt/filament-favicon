<?php

namespace pxlrbt\FilamentFavicon\Commands;

use Illuminate\Console\Command;
use pxlrbt\FilamentFavicon\Support\FaviconService;

class ClearFaviconsCommand extends Command
{
    protected $signature = 'favicons:clear';

    protected $description = 'Clear Filament Favicons';

    public function handle(FaviconService $faviconService): void
    {
        $this->info('Clearing Favicons…');

        $faviconService->clear();

        $this->info('Cleared!');
    }
}
