<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $entry_type
 */
class CompetitionEntry extends BaseModel
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function (self $competition) {
            $competition->id = Str::uuid()->toString();
        });
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
