<?php

namespace pxlrbt\FilamentFavicon\FaviconFetchers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use pxlrbt\FilamentFavicon\Events\FaviconFetched;
use pxlrbt\FilamentFavicon\Support\FaviconService;

class DuckDuckGo implements FaviconFetcher
{
    public function fetch(string $domain): void
    {
        $faviconService = resolve(FaviconService::class);

        try {
            $resp = Http::throw()->get("https://icons.duckduckgo.com/ip3/{$domain}.ico");

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
