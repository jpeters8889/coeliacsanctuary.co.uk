<?php

declare(strict_types=1);

namespace Coeliac\Common;

use Coeliac\Common\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class ArchitectGateway implements \JPeters\Architect\ArchitectGateway
{
    public function canUseArchitect(Authenticatable $user): bool
    {
        /* @var User $user */
        return in_array($user->email, ['jamie@jamie-peters.co.uk', 'contact@coeliacsanctuary.co.uk']);
    }
}
