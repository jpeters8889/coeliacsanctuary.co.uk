<?php

declare(strict_types=1);

namespace Coeliac\Common;

use Illuminate\Contracts\Auth\Authenticatable;

class ArchitectGateway implements \JPeters\Architect\ArchitectGateway
{
    public function canUseArchitect(Authenticatable $user): bool
    {
        /* @phpstan-ignore-next-line  */
        return in_array($user->email, ['jamie@jamie-peters.co.uk', 'contact@coeliacsanctuary.co.uk']);
    }
}
