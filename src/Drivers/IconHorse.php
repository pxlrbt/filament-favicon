<?php

namespace pxlrbt\FilamentFavicon\Drivers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use pxlrbt\FilamentFavicon\Events\FaviconFetched;
use pxlrbt\FilamentFavicon\Support\FaviconService;

class IconHorse implements FaviconFetcher
{
    public function fetch(string $domain): void
    {
        $faviconService = resolve(FaviconService::class);

        try {
            $resp = Http::throw()->get("https://icon.horse/icon/{$domain}?status_code_404=true");

            $extension = $faviconService->getExtension($resp->header('Content-Type'));
            $faviconService->store("{$domain}.{$extension}", $resp->body());

            event(new FaviconFetched($domain));
        } catch (RequestException $exception) {
            if ($exception->response->notFound()) {
                $faviconService->store("{$domain}.404", '');
            }
        }
    }
}
