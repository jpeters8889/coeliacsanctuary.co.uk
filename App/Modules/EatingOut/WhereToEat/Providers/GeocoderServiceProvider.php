<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Providers;

use Spatie\Geocoder\Geocoder;

class GeocoderServiceProvider extends \Spatie\Geocoder\GeocoderServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->bind(Geocoder::class, 'geocoder');
    }
}
