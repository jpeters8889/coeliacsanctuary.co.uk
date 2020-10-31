<?php

declare(strict_types=1);

namespace Coeliac\Common\FeaturedImages;

use Coeliac\Common\Models\FeaturedImage;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;

class Repository extends AbstractRepository
{
    protected $withs = ['images', 'images.image'];

    protected function model(): string
    {
        return FeaturedImage::class;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->active()->orderBy('order');
    }
}
