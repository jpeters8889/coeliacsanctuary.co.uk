<?php

namespace Coeliac\StaticPageGenerator;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class GenerateStaticPage
{
    public function __construct(protected Browsershot $browsershot)
    {
        //
    }

    public function setUrl(string $url): self
    {
        $this->browsershot->setUrl($this->formatUrl($url));

        return $this;
    }

    public function generateHtml(): string
    {
        $body = $this->browsershot->bodyHtml();

        $body = Str::replace('<div id="coeliac"', '<div id="coeliac" data-server-rendered="true"', $body);

        return $body;
    }

    protected function formatUrl(string $url): string
    {
        $domain = config('app.url');

        if (Str::contains($url, $domain)) {
            return $url;
        }

        return Str::of($url)->trim('/')->prepend($domain.'/')->toString();
    }
}
