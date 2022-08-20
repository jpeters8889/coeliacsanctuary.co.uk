<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Services;

use Carbon\Carbon;
use Coeliac\Modules\Member\Contracts\UserActivityMonitor as Contract;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Illuminate\Support\Collection;

class UserActivityMonitor implements Contract
{
    private RedisFactory $factory;

    public function __construct(RedisFactory $factory)
    {
        $this->factory = $factory;
    }

    public function mark(User $user): void
    {
        /** @phpstan-ignore-next-line  */
        $this->factory->hset('user.lastActivity', $user->id, Carbon::now());
    }

    public function lastVisitForUser(User $user): ?Carbon
    {
        /** @phpstan-ignore-next-line  */
        $lastVisit = $this->factory->hget('user.lastActivity', $user->id);

        if ($lastVisit) {
            return Carbon::make($lastVisit);
        }

        return null;
    }

    public function all(): Collection
    {
        /** @phpstan-ignore-next-line  */
        return (new Collection($this->factory->hgetall('user.lastActivity')))
            ->map(fn ($date, $userId) => [
                'user' => User::query()->find($userId),
                'date' => Carbon::make($date),
            ])
            ->reject(fn ($item) => ! $item['user'] || ! $item['date']);
    }

    public function delete(User $user): void
    {
        /** @phpstan-ignore-next-line  */
        $this->factory->hdel('user.lastActivity', $user->id);
    }
}
