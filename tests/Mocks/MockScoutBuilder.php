<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Laravel\Scout\Builder;

class MockScoutBuilder extends Builder
{
    public function with(...$params)
    {
        return $this;
    }
}
