<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @extends BaseModel<UserLevel> */
class UserLevel extends BaseModel
{
    public const SHOP = 1;
    public const MEMBER = 2;
    public const ADMIN = 3;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
