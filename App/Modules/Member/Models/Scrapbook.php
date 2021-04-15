<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scrapbook extends BaseModel
{
    protected $casts = [
        'user_id' => 'int',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ScrapbookItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
