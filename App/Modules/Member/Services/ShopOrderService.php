<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Services;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Database\Eloquent\Collection;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Illuminate\Contracts\Auth\Authenticatable;
use Coeliac\Modules\Shop\Models\ShopOrderState;

class ShopOrderService
{
    private Authenticatable $user;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function list(): Collection
    {
        return ShopOrder::query()
            ->where('user_id', $this->user->getAuthIdentifier())
            ->whereNotIn('state_id', [ShopOrderState::STATE_BASKET, ShopOrderState::STATE_EXPIRED])
            ->withCount('items')
            ->with(['payment', 'state', 'address'])
            ->latest()
            ->get()->transform(fn (ShopOrder $order) => $this->basicData($order));
    }

    protected function basicData(ShopOrder $order): array
    {
        return [
            'order_date' => $order->created_at,
            'reference' => $order->order_key,
            'number_of_items' => (int) $order->items_count,
            'total_cost' => $order->payment->total,
            'state' => $order->state->state,
            'shipped_at' => $order->shipped_at,
        ];
    }

    public function info(ShopOrder $order): array
    {
        $order->load([
            'address', 'items', 'items.product', 'items.product.images',
            'items.product.images.image', 'payment', 'payment.type',
        ]);

        return array_merge($this->basicData($order), [
            'address' => $order->address->only(['name', 'line_1', 'line_2', 'line_3', 'town', 'postcode', 'country']),
            'items' => $this->items($order),
            'payment' => $this->payment($order),
        ]);
    }

    protected function items(ShopOrder $order): Collection
    {
        return $order->items
            ->makeHidden(['product'])
            ->makeVisible(['product_title', 'product_price'])
            ->transform(fn (ShopOrderItem $item) => array_merge(
                $item->toArray(),
                ['image' => $item->product->first_image],
            ));
    }

    protected function payment(ShopOrder $order): \Coeliac\Modules\Shop\Models\ShopPayment
    {
        return $order->payment
            ->makeVisible(['payment_type'])
            ->makeHidden(['id', 'order_id', 'payment_type_id', 'created_at', 'updated_at', 'type']);
    }
}
