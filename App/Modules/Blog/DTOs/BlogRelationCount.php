<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\DTOs;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class BlogRelationCount extends DataTransferObject
{
    public int $id;

    public string $title;

    public string $slug;

    /** @var Collection<int, int> */
    public Collection $blogs;
}
