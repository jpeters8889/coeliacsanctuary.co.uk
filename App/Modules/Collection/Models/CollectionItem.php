<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property BaseModel $item
 * @property string    $description
 * @property Collection $collection
 */
class CollectionItem extends BaseModel
{
    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function item(): MorphTo
    {
        return $this->morphTo('item');
    }
}
