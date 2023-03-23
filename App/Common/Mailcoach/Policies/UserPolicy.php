<?php

namespace Coeliac\Common\Mailcoach\Policies;

class UserPolicy extends \Spatie\Mailcoach\Domain\Settings\Policies\UserPolicy
{
    public function __call($method, $args): bool
    {
        return false;
    }
}
