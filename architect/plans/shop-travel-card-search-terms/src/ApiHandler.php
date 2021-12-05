<?php

namespace Coeliac\Architect\Plans\ShopTravelCardSearchTerms;

use Coeliac\Modules\Shop\Models\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApiHandler
{
    public function handle(Request $request)
    {
        $products = new Collection();

        ShopCategory::query()
            ->with(['products', 'products.prices', 'products.images'])
            ->whereIn('id', [1,8])
            ->get()
            ->each(function (ShopCategory $category) use ($products) {
                $products->push(...$category->products);
            });

        return $products
            ->when(
                $request->has('exclude'),
                fn (Collection $collection) => $collection->reject(
                    fn ($item) => in_array($item->id, explode(',', $request->get('exclude')), false)
                )
            )
            ->sortBy('title')
            ->values();
    }
}
