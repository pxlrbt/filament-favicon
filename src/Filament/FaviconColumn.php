<?php

namespace pxlrbt\FilamentFavicon\Filament;

use Filament\Tables\Columns\ImageColumn;
use pxlrbt\FilamentFavicon\Support\FaviconService;

class FaviconColumn extends ImageColumn
{
    public static function getDefaultName(): ?string
    {
        return 'favicon';
    }

    protected function setUp(): void
    {
        $this
            ->label('')
            ->square()
            ->imageSize(32)
            ->defaultImageUrl(null)
            ->extraImgAttributes(['style' => 'object-fit:contain']);
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
