<?php

declare(strict_types=1);

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

$factory->define(WhereToEatCountry::class, function () {
    return [
        'country' => 'England',
    ];
});
