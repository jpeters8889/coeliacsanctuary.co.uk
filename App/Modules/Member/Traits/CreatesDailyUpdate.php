<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Traits;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;

/** @mixin BaseModel */
trait CreatesDailyUpdate
{
    public static function bootCreatesDailyUpdate(): void
    {
        static::created(function (BaseModel $model) {
            if (!static::dispatchUpdateOnCreate()) {
                return;
            }

            self::dispatchDailyUpdate($model);
        });
    }

    abstract protected static function dailyUpdateType(): array|int;

    protected static function dispatchUpdateOnCreate(): bool
    {
        return true;
    }

    protected static function dispatchDailyUpdate(BaseModel $model): void
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = resolve(Dispatcher::class);

        $types = static::dailyUpdateType();

        if (!is_array($types)) {
            $types = [$types];
        }

        foreach ($types as $type) {
            $dispatcher->dispatch(new DailyUpdateItemCreated($model, $type));
        }
    }
}
