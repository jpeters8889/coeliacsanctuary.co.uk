<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Support\Collection;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Member\Requests\ViewOrderRequest;

class OrdersController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Purchase History')
            ->breadcrumbs([
                ['title' => 'Your Dashboard', 'link' => '/member/dashboard'],
            ], 'Purchase History')
            ->render('modules.member.dashboards.orders', [
                'user' => $request->user(),
            ]);
    }

    public function list(Request $request)
    {
        return ShopOrder::query()
            ->where('user_id', $request->user()->id)
            ->whereNotIn('state_id', [ShopOrderState::STATE_BASKET])
            ->withCount('items')
            ->with(['payment', 'state', 'address'])
            ->latest()
            ->get()
            ->transform(fn (ShopOrder $order) => [
                'order_date' => $order->created_at,
                'reference' => $order->order_key,
                'number_of_items' => (int) $order->items_count,
                'total_cost' => $order->payment->total,
                'state' => $order->state->state,
                'shipped_at' => $order->shipped_at,
            ])
            ->paginate(10);
    }

    public function get(ViewOrderRequest $request)
    {
        return (new Collection([$request->order()]))->map(function (ShopOrder $order) {
            return [
                'order_date' => $order->created_at,
                'reference' => $order->order_key,
                'number_of_items' => (int) $order->items_count,
                'total_cost' => $order->payment->total,
                'state' => $order->state->state,
                'shipped_at' => $order->shipped_at,
                'addresses' => [],
                'items' => [],
                'payment' => [],
            ];
        })->first();
    }
}
