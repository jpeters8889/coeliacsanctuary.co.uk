<?php

declare(strict_types=1);

namespace Coeliac\Common\Search;

interface SearchableContract
{
    public function toSearchableArray(): array;

    public function shouldBeSearchable(): bool;

    public function getScoutKey(): mixed;
}
