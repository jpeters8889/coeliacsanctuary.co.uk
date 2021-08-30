<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Mattiasgeniar\Percentage\Percentage;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopMassDiscount;

class ApplyMassDiscounts extends Command
{
    protected $signature = 'coeliac:apply_mass_discounts';

    public function handle(): void
    {
        ShopMassDiscount::query()
            ->whereDate('start_at', '<=', Carbon::now())
            ->where('created', false)
            ->with(['assignedCategories', 'assignedCategories.products', 'assignedCategories.products.variants'])
            ->get()
            ->each(static function (ShopMassDiscount $discount) {
                $discount->assignedCategories
                    ->each(static function (ShopCategory $category) use ($discount) {
                        $category->products()
                            ->with('prices')
                            ->whereHas('variants', fn ($query) => $query->where('live', 1))
                            ->each(static function (ShopProduct $product) use ($discount) {
                                $product->prices()->create([
                                    'price' => $product->currentPrice - Percentage::of($discount->percentage, (int) $product->currentPrice),
                                    'sale_price' => true,
                                    'start_at' => $discount->start_at,
                                    'end_at' => $discount->end_at,
                                ]);
                            });
                    });

                $discount->update(['created' => true]);
            });
    }
}
