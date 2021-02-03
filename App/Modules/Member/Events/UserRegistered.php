<?php

namespace Coeliac\Modules\Member\Events;

use Coeliac\Modules\Member\Models\User;

class UserRegistered
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user(): User
    {
        return $this->user;
    }
}
