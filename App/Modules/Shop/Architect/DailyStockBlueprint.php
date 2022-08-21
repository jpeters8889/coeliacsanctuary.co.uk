<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Architect\Cards\ShopDailyStock\Card;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;

class DailyStockBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Daily Stock';
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function model(): string
    {
        return ShopOrder::class;
    }

    public function plans(): array
    {
        return [];
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function blueprintRoute(): string
    {
        return 'shop-daily-stock';
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->whereIn('state_id', [ShopOrderState::STATE_PAID, ShopOrderState::STATE_PRINTED])
            ->take(1);
    }

    public function perPage(): int
    {
        return 1;
    }

    public function paginate(): bool
    {
        return false;
    }
}
