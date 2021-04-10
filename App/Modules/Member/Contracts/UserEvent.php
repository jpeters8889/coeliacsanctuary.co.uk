<?php

namespace Coeliac\Modules\Member\Contracts;

use Coeliac\Modules\Member\Models\User;

interface UserEvent
{
    public function user(): User;
}
