<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;
use Coeliac\Modules\Shop\Models\ShopPostagePrice;
use Coeliac\Modules\Shop\Models\ShopShippingMethod;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Textfield;

class PostagePricesBlueprint extends Blueprint
{
    public function blueprintSite(): string
    {
        return 'Shop';
    }

    public function blueprintName(): string
    {
        return 'Postage Prices';
    }

    public function model(): string
    {
        return ShopPostagePrice::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('max_weight', 'Max Weight (g)'),

            Label::generate('architect_price', 'Price')->hideOnForms(),

            Label::generate('shipping_method')->hideOnForms(),

            Label::generate('areas')->hideOnForms(),

            Textfield::generate('price', 'Price (In Pence)')->hideOnIndex(),

            Select::generate('shipping_method_id', 'Shipping Method')
                ->hideOnIndex()
                ->options(
                    ShopShippingMethod::all()
                        ->mapWithKeys(fn (ShopShippingMethod $method) => [$method->id => $method->shipping_method])
                        ->toArray()
                ),

            Select::generate('postage_country_area_id', 'Postage Area')
                ->hideOnIndex()
                ->options(
                    ShopPostageCountryArea::all()
                        ->mapWithKeys(fn (ShopPostageCountryArea $area) => [$area->id => $area->area])
                        ->toArray()
                ),
        ];
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->selectRaw(implode(',', [
                '*',
                'concat("£", format(price / 100, 2)) architect_price',
                '(select shipping_method from shop_shipping_methods where shop_shipping_methods.id = shop_postage_prices.shipping_method_id) shipping_method',
                '(select area from shop_postage_country_areas where shop_postage_country_areas.id = shop_postage_prices.postage_country_area_id) areas',
            ]));
    }

    public function ordering(): array
    {
        return [
            [
                'postage_country_area_id',
                'asc',
            ],
            [
                'shipping_method_id',
                'asc',
            ],
            [
                'max_weight',
                'asc',
            ],
        ];
    }

    public function perPage(): int
    {
        return 100;
    }

    public function blueprintRoute(): string
    {
        return 'shop-postage-prices';
    }

    public function searchable(): bool
    {
        return false;
    }
}
