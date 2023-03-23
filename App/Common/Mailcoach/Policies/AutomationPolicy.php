<?php

namespace Coeliac\Common\Mailcoach\Policies;

class AutomationPolicy extends \Spatie\Mailcoach\Domain\Automation\Policies\AutomationPolicy
{
    public function __call($method, $args): bool
    {
        return false;
    }
}
