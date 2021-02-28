<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Response;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Requests\SubscriptionSearchRequest;

class SubscriptionSearchController extends BaseController
{
    public function __invoke(SubscriptionSearchRequest $request)
    {
        $item = $request->subscription()->subscriptions()
            ->where('user_id', $request->user()->id)
            ->where('subscribable_type', get_class($request->subscribable()))
            ->where('subscribable_id', $request->subscribable()->id)
            ->first();

        if (!$item) {
            return new Response('', 204);
        }

        return ['id' => $item->id];
    }
}
