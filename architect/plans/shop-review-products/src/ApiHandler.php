<?php

namespace Coeliac\Architect\Plans\ShopReviewProducts;

use Coeliac\Modules\Shop\Models\ShopOrderReviewItem;
use Coeliac\Modules\Shop\ProductRepository;

class ApiHandler
{
    public function getProducts($id)
    {
        return ShopOrderReviewItem::query()
            ->where('review_id', $id)
            ->with('product')
            ->get()
            ->transform(fn(ShopOrderReviewItem $item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'title' => $item->product->title,
                'rating' => $item->rating,
                'review' => $item->review,
            ]);
    }

    public function productList() {
        return app(ProductRepository::class)->all();
    }
}
