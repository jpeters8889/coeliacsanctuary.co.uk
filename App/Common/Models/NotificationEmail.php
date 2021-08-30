<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Casts\EmailData;
use Coeliac\Modules\Member\Models\User;

/**
 * @property string $key
 * @property EmailData $data
 * @property string $template
 */
class NotificationEmail extends BaseModel
{
    protected $casts = [
        'data' => EmailData::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function (NotificationEmail $email) {
            if (!$email->key) {
                $email->key = Str::uuid()->toString();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
