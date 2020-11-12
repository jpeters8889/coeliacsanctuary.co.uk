<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Architect\Plans\CoeliacShopOrderItems\Plan as ItemList;

class BasketBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Baskets';
    }

    public function model(): string
    {
        return ShopOrder::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('id'),

            Textfield::generate('token'),

            DateTime::generate('created_at'),

            DateTime::generate('updated_at'),

            Boolean::generate('converted'),

            Boolean::generate('expired'),

            ItemList::generate('items'),
        ];
    }

    public function getData(): Builder
    {
        $states = [
            ShopOrderState::STATE_PAID,
            ShopOrderState::STATE_PRINTED,
            ShopOrderState::STATE_SHIPPED,
            ShopOrderState::STATE_COMPLETE,
        ];

        return parent::getData()
            ->selectRaw(implode(',', [
                '*',
                'if(state_id in('.implode(',', $states).'), 1, 0) converted',
                'if(state_id = '.ShopOrderState::STATE_EXPIRED.', 1, 0) expired',
                '(select count(*) from shop_order_items where order_id = shop_orders.id) items',
            ]));
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function ordering(): array
    {
        return [
            'created_at',
            'desc',
        ];
    }

    public function displayCount(): int
    {
        return ShopOrder::query()->where('state_id', ShopOrderState::STATE_BASKET)->count();
    }

    public function blueprintRoute(): string
    {
        return 'shop-baskets';
    }

    public function searchable(): bool
    {
        return false;
    }
}
