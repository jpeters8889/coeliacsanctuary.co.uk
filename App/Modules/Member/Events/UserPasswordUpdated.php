<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Events;

use Coeliac\Modules\Member\Models\User;

class UserPasswordUpdated
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user(): User
    {
        return $this->user;
    }
}
