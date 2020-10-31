<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Providers;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Coeliac\Modules\Shop\PostcodeLookup\Service;
use Coeliac\Modules\Shop\PostcodeLookup\GetAddress\Lookup;
use Coeliac\Modules\Shop\PostcodeLookup\GetAddress\Parser;

class PostcodeLookupServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Service::class, static function () {
            $client = new Client([
                'base_uri' => 'https://api.getAddress.io',
                'auth' => [
                    'api-key',
                    Container::getInstance()->make(Repository::class)->get('services.postcode.key'),
                ],
            ]);

            return new Lookup($client, new Parser());
        });
    }
}
