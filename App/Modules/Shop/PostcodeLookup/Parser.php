<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\PostcodeLookup;

use Illuminate\Support\Collection;

interface Parser
{
    public function parse(object $response, string $postcode): Collection;
}
