<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Architect\Plans\ShopReviewProducts\Plan;
use Coeliac\Modules\Shop\Models\ShopOrderReview;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;

class ShopReviewsBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Reviews';
    }

    public function model(): string
    {
        return ShopOrderReview::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name'),

            Plan::generate('products'),

            DateTime::generate('created_at')
                ->hideOnForms(),
        ];
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->select('*')
            ->with(['products', 'products.product', 'products.product.prices', 'products.product.images', 'order']);
    }

    public function blueprintRoute(): string
    {
        return 'shop-reviews';
    }
}
