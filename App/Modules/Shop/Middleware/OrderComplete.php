<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Middleware;

use Closure;
use Illuminate\Http\Request;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;

class OrderComplete
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('basket_token')) {
            return redirect('/shop');
        }

        $token = $request->session()->get('basket_token');

        if (!ShopOrder::query()->where('token', $token)->where('state_id', '!=', ShopOrderState::STATE_EXPIRED)->first()) {
            return redirect('/shop/basket');
        }

        return $next($request);
    }
}
