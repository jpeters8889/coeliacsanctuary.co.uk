<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\OrderShipped;

use Illuminate\Http\Request;
use Coeliac\Modules\Shop\Events\ShipOrder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Rules\ActiveOrder;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Modules\Shop\Events\CancelOrder;

class ApiHandler
{
    public function ship(Request $request, Dispatcher $eventDispatcher)
    {
        $order = $this->validateRequest($request);

        $eventDispatcher->dispatch(new ShipOrder($order));
    }

    public function cancel(Request $request, Dispatcher $eventDispatcher)
    {
        $order = $this->validateRequest($request);

        $eventDispatcher->dispatch(new CancelOrder($order));
    }

    protected function validateRequest(Request $request): ShopOrder
    {
        $request->validate([
            'id' => ['bail', 'required', 'numeric', 'exists:shop_orders', new ActiveOrder()],
        ]);

        return ShopOrder::query()->findOrFail($request->input('id'));
    }
}
