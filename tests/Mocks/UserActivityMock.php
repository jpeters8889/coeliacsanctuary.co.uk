<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Carbon\Carbon;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Collection;

class UserActivityMock implements UserActivityMonitor
{
    protected array $store = [];

    public function mark(User $user): void
    {
        $this->store[$user->id] = Carbon::now();
    }

    public function lastVisitForUser(User $user): ?Carbon
    {
        return $this->store[$user->id] ?? null;
    }

    public function all(): Collection
    {
        return (collect($this->store))
            ->map(fn ($date, $userId) => [
                'user' => User::query()->find($userId),
                'date' => Carbon::make($date),
            ]);
    }

    public function delete(User $user): void
    {
        unset($this->store[$user->id]);
    }

    public function reset(): void
    {
        $this->store = [];
    }
}
