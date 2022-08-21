<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @extends BaseModel<ScrapbookItem>
 *
 * @property BaseModel $item
 * @property int $id
 * @property Carbon $created_at
 */
class ScrapbookItem extends BaseModel
{
    protected $casts = [
      'scrapbook_id' => 'int',
    ];

    public function item(): MorphTo
    {
        return $this->morphTo('item');
    }

    public function scrapbook(): BelongsTo
    {
        return $this->belongsTo(Scrapbook::class);
    }
}
