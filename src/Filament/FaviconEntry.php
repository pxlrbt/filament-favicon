<?php

namespace pxlrbt\FilamentFavicon\Filament;

use Filament\Tables\Columns\ImageColumn;
use pxlrbt\FilamentFavicon\Support\FaviconService;

class FaviconEntry extends ImageColumn
{
    public static function getDefaultName(): ?string
    {
        return 'favicon';
    }

    protected function setUp(): void
    {
        $this
            ->label('Favicon')
            ->disk('public')
            ->square()
            ->imageSize(32)
            ->extraImgAttributes(['style' => 'object-fit: contain'])
            ->url(fn ($state, FaviconService $iconService) => $iconService->url($state));
    }
}
