<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Coeliac\Modules\Member\Models\User;

interface UserActivityMonitor
{
    public function mark(User $user): void;

    public function lastVisitForUser(User $user): ?Carbon;

    public function all(): Collection;

    public function delete(User $user): void;
}
