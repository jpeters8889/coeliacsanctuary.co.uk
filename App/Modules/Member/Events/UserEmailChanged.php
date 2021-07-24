<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Events;

use Coeliac\Modules\Member\Models\User;

class UserEmailChanged
{
    protected User $user;
    protected string $oldEmail;

    public function __construct(User $user, string $oldEmail)
    {
        $this->user = $user;
        $this->oldEmail = $oldEmail;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function oldEmail(): string
    {
        return $this->oldEmail;
    }
}
