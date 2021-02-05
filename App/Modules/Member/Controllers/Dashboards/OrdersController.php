<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

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
            ->withCount('items')
            ->with(['payment', 'state', 'address'])
            ->latest()
            ->get()
            ->transform(fn(ShopOrder $order) => [
                'order_date' => $order->created_at,
                'reference' => $order->order_key,
                'number_of_items' => (int) $order->items_count,
                'total_cost' => $order->payment->total,
                'state' => $order->state->state,
                'shipping_address' => [
                    'name' => $order->address->name,
                    'line_1' => $order->address->line_1,
                    'line_2' => $order->address->line_2,
                    'line_3' => $order->address->line_3,
                    'town' => $order->address->town,
                    'postcode' => $order->address->postcode,
                    'county' => $order->address->country,
                ],
                'shipped_at' => $order->shipped_at,
            ])
            ->paginate(10);
    }
}
