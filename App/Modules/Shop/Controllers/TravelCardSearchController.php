<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\TravelCardSearchTerm;
use Coeliac\Modules\Shop\Models\TravelCardSearchTermHistory;
use Coeliac\Modules\Shop\Requests\TravelCardSearchRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TravelCardSearchController extends BaseController
{
    public function index(TravelCardSearchRequest $request): array
    {
        TravelCardSearchTermHistory::query()
            ->firstOrCreate(['term' => $request->input('term')])
            ->increment('hits');

        return [
            'results' => TravelCardSearchTerm::query()
                ->where('term', 'like', "%{$request->input('term')}%")
                ->get()
                ->map(fn (TravelCardSearchTerm $searchTerm) => [
                    'id' => $searchTerm->id,
                    'term' => Str::replace(
                        $request->input('term'),
                        "<strong>{$request->input('term')}</strong>",
                        $searchTerm->term,
                    ),
                    'type' => $searchTerm->type,
                ]),
        ];
    }

    public function get($id): array
    {
        /** @var TravelCardSearchTerm $searchTerm */
        $searchTerm = TravelCardSearchTerm::query()->findOrFail($id);

        $searchTerm->increment('hits');

        /** @var Collection<int, ShopProduct> $products */
        $products = $searchTerm->products->load(['variants', 'categories', 'prices', 'images']);

        return [
            'term' => Str::title($searchTerm->term),
            'type' => $searchTerm->type,
            'products' => $products->map(fn (ShopProduct $product) => [
                'title' => $product->title,
                'link' => $product->link,
                'price' => $product->currentPrice,
                'image' => $product->mainImage,
                'category' => $product->categories[0]->title,
                'description' => $product->description,
                'id' => $product->id,
                'variant_id' => $product->variants[0]->id,
                'inStock' => $product->variants[0]->quantity > 0,
            ]),
        ];
    }
}
