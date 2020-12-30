<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Traits;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Collection\Models\CollectionItem;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/** @mixin BaseModel */
trait IsCollectionItem
{
    public function associatedCollections(): MorphMany
    {
        return $this->morphMany(CollectionItem::class, 'item');
    }
}
