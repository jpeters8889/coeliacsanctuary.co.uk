<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\DTOs;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class RecipeRelationCount extends DataTransferObject
{
    public int $id;

    public string $title;

    /** @var Collection<int, int> */
    public Collection $recipes;
}
