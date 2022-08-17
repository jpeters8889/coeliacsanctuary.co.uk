<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Common\Models\Image;
use Coeliac\Modules\Shop\Models\ShopOrderReviewItem;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductReviewsController extends BaseController
{
    public function get(ProductRepository $repository, mixed $id): LengthAwarePaginator
    {
        /** @var ?ShopProduct $product */
        $product = $repository->get($id);

        abort_if(!$product, 404);

        return $product->reviews()
            ->with(['parent'])
            ->latest()
            ->paginate(5)
            ->through(fn (ShopOrderReviewItem $review) => [
                'id' => $review->id,
                'name' => $review->parent->name !== '' ? $review->parent->name : 'Anonymous',
                'rating' => $review->rating,
                'review' => $review->review,
                'date' => $review->created_at,
            ]);
    }
}
