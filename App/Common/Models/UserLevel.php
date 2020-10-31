<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;

class UserLevel extends BaseModel
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
