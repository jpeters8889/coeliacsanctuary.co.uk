<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @extends BaseModel<UserPasswordChange> */
class UserPasswordChange extends BaseModel
{
    public const CREATED_AT = 'changed_at';
    public const UPDATED_AT = null;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
