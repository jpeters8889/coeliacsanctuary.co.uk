<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Coeliac\Modules\Member\Contracts\Updatable;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;
use Illuminate\Http\Response;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Requests\DailyUpdateSearchRequest;

class DailyUpdatesSearchController extends BaseController
{
    public function __invoke(DailyUpdateSearchRequest $request): Response|array
    {
        if (!$request->updatable() instanceof Updatable) {
            return new Response('', 204);
        }

        /** @var UserDailyUpdateSubscription $item */
        $item = $request->dailyUpdate()->subscriptions()
            ->where('user_id', $request->user()->id)
            ->where('updatable_type', get_class($request->updatable()))
            ->where('updatable_id', $request->updatable()->id)
            ->first();

        if (!$item instanceof UserDailyUpdateSubscription) {
            return new Response('', 204);
        }

        return ['id' => $item->id];
    }
}
