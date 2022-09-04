<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Architect\Plans\OrderDispatchSlip\Plan as DispatchSlip;
use Coeliac\Architect\Plans\OrderInfo\Plan as OrderInfo;
use Coeliac\Architect\Plans\OrderShipped\Plan as Shipped;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Textfield;

class OrderBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Orders';
    }

    public function model(): string
    {
        return ShopOrder::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('order_key', 'Order ID'),

            DateTime::generate('order_date'),

            Textfield::generate('total_cost'),

            Label::generate('address'),

            Textfield::generate('payment_method'),

            Shipped::generate('shipped', 'Shipped?'),

            OrderInfo::generate('info', ' '),

            DispatchSlip::generate('plan', ' '),
        ];
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->whereNotIn('state_id', [ShopOrderState::STATE_BASKET, ShopOrderState::STATE_EXPIRED])
            ->selectRaw(implode(',', [
                'shop_orders.*',
                'shop_payments.created_at order_date',
                'concat("£", format(shop_payments.total / 100, 2)) total_cost',
                'concat('.implode(',', [
                    'concat(user_addresses.name, "<br>")',
                    'concat(line_1, "<br>")',
                    'if(ifnull(line_2, "") != "", concat(line_2, "<br>"), "")',
                    'if(ifnull(line_3, "") != "", concat(line_3, "<br>"), "")',
                    'concat(town, "<br>")',
                    'concat(postcode, "<br>")',
                ]).') address',
                'shop_payment_types.type payment_method',
                'json_object("state_id", state_id, "shipped_at", shipped_at) shipped',
            ]))
            ->leftJoin('shop_payments', 'shop_payments.order_id', '=', 'shop_orders.id')
            ->leftJoin('shop_payment_types', 'shop_payments.payment_type_id', '=', 'shop_payment_types.id')
            ->leftJoin('user_addresses', function (JoinClause $join) {
                return $join->on('user_addresses.id', '=', 'shop_orders.user_address_id')
                    ->where('user_addresses.type', 'Shipping');
            });
    }

    public function displayCount(): int
    {
        return ShopOrder::query()
            ->whereIn('state_id', [ShopOrderState::STATE_PAID, ShopOrderState::STATE_PRINTED])
            ->count();
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function blueprintRoute(): string
    {
        return 'shop-orders';
    }

    public function button(): array
    {
        return [
            'label' => 'Print All Orders',
            'link' => '/page/dispatch-slips/active'
        ];
    }

    public function filters(): array
    {
        return [
            'state_id' => [
                'name' => 'State',
                'options' => ShopOrderState::query()
                    ->whereNotIn('id', [ShopOrderState::STATE_BASKET, ShopOrderState::STATE_EXPIRED])
                    ->get()
                    ->mapWithKeys(fn (ShopOrderState $state) => [$state->id => $state->state]),
                'filter' => fn (Builder $builder, $value) => $builder->where('state_id', $value),
            ],
        ];
    }

    public function searchUsing(Builder $builder, string $searchTerm, array $columns = []): Builder
    {
        return $builder
            ->where('shop_orders.id', $searchTerm)
            ->orWhere('shop_orders.order_key', 'like', "%{$searchTerm}%")
            ->orWhere('user_addresses.name', 'like', "%{$searchTerm}%")
            ->orWhere('user_addresses.line_1', 'like', "%{$searchTerm}%");
    }
}
