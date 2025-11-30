<?php

namespace pxlrbt\FilamentFavicon\Filament;

use Filament\Infolists\Components\ImageEntry;
use pxlrbt\FilamentFavicon\Support\FaviconService;

class FaviconEntry extends ImageEntry
{
    public static function getDefaultName(): ?string
    {
        return 'favicon';
    }

    protected function setUp(): void
    {
        $this
            ->label('Favicon')
            ->square()
            ->imageSize(32);
    }

    public function getImageUrl(?string $state = null): ?string
    {
        $faviconService = resolve(FaviconService::class);

        return $faviconService->url($state);
    }

    public function toEmbeddedHtml(): string
    {
        $state = $this->getState();
        $imageUrl = $this->getImageUrl($state);

        if (blank($imageUrl)) {
            return '';
        }

        return parent::toEmbeddedHtml();
    }
}
