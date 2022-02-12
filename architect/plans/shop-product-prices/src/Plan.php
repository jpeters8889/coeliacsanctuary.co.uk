<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ShopProductPrices;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Coeliac\Modules\Shop\Models\ShopProduct;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public bool $deferUpdate = true;

    public function vuePrefix(): string
    {
        return 'shop-product-prices';
    }

    public function handleUpdate(Model $model, $column, $value, $index = null)
    {
        /** @var ShopProduct $model */
        $prices = json_decode($value, true);

        $pricesToAdd = [];

        foreach ($prices as $price) {
            $pricesToAdd[] = $model->prices()->make([
                'price' => $price['price'],
                'sale_price' => $price['sale_price'],
                'start_at' => Carbon::parse($price['start_at']),
                'end_at' => $price['end_at'] !== null ? Carbon::parse($price['end_at']) : null,
            ]);
        }

        $model->prices()->delete();

        foreach ($pricesToAdd as $price) {
            $price->save();
        }
    }
}
