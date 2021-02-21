<?php

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scrapbook extends BaseModel
{
    public function items(): HasMany
    {
        return $this->hasMany(ScrapbookItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
