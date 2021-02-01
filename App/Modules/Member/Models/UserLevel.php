<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

class UserLevel extends BaseModel
{
    public const SHOP = 1;
    public const MEMBER = 2;
    public const ADMIN = 3;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
