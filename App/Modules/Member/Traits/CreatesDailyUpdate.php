<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Traits;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;

/** @mixin BaseModel */
trait CreatesDailyUpdate
{
    public static function bootCreatesDailyUpdate()
    {
        static::created(function (BaseModel $model) {
            /** @var Dispatcher $dispatcher */
            $dispatcher = resolve(Dispatcher::class);

            $types = static::dailyUpdateType();

            if (!is_array($types)) {
                $types = [$types];
            }

            foreach ($types as $type) {
                $dispatcher->dispatch(new DailyUpdateItemCreated($model, $type));
            }
        });
    }

    abstract protected static function dailyUpdateType();
}
