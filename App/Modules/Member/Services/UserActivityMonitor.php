<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor as Contract;

class UserActivityMonitor implements Contract
{
    private RedisFactory $factory;

    public function __construct(RedisFactory $factory)
    {
        $this->factory = $factory;
    }

    public function mark(User $user): void
    {
        $this->factory->hset('user.lastActivity', $user->id, Carbon::now());
    }

    public function lastVisitForUser(User $user): ?Carbon
    {
        $lastVisit = $this->factory->hget('user.lastActivity', $user->id);

        if ($lastVisit) {
            return Carbon::make($lastVisit);
        }

        return null;
    }

    public function all(): Collection
    {
        return (new Collection($this->factory->hgetall('user.lastActivity')))
            ->map(fn ($date, $userId) => [
                'user' => User::query()->find($userId),
                'date' => Carbon::make($date),
            ])
            ->reject(fn ($item) => !$item['user'] || !$item['date']);
    }

    public function delete(User $user): void
    {
        $this->factory->hdel('user.lastActivity', $user->id);
    }
}
