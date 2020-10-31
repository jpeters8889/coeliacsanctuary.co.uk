<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\PostcodeLookup;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

interface Service
{
    public function __construct(Client $client, Parser $parser);

    public function lookup($postcode): Collection;
}
